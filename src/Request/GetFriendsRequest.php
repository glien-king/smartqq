<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Collection\Collection;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Category;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Utils;

class GetFriendsRequest extends Request
{

    protected $uri = 'http://s.web2.qq.com/api/get_user_friends2';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', json_encode([
            'vfwebqq' => $credential->getVfWebQQ(),
            'hash' => Utils::hash($credential->getUin(), $credential->getPtWebQQ()),
        ]));
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @return EntityCollection
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            //好友基本信息
            $friendDatas = (new Collection($jsonData['result']['friends']))->combine('uin', function($entity){
                return $entity;
            });
            //markNames
            $markNames = (new Collection($jsonData['result']['marknames']))->combine('uin', function($entity){
                return $entity;
            });
            //分类
            $categories = (new Collection($jsonData['result']['categories']))->combine('index', function($entity){
                return $entity;
            });
            //vip信息
            $vipInfos = (new Collection($jsonData['result']['vipinfo']))->combine('u', function($entity){
                return $entity;
            });
            $friends = [];
            foreach ($jsonData['result']['info'] as $friendData) {
                $uin = $friendData['uin'];
                $friend = [
                    'uin' => $friendData['uin'],
                    'flag' => $friendData['flag'],
                    'face' => $friendData['face'],
                    'nick' => $friendData['nick'],
                    'markName' => isset($markNames[$uin]) ? $markNames[$uin]['markname'] : null,
                    'isVip' => isset($vipInfos[$uin]) ? $vipInfos[$uin]['is_vip'] == 1 : false,
                    'vipLevel' => isset($vipInfos[$uin]) ? $vipInfos[$uin]['vip_level'] : 0,
                ];
                $category = null;
                if (isset($friendDatas[$uin])) {
                    $categoryIndex = $friendDatas[$uin]['categories'];
                    if (isset($categories[$categoryIndex])) {
                        $category = EntityFactory::createEntity(Category::class, [
                            'index' => $categories[$categoryIndex]['index'],
                            'name' => $categories[$categoryIndex]['name'],
                            'sort' => $categories[$categoryIndex]['sort'],
                        ]);
                    }
                }
                $friend['category'] = $category;
                $friends[] = EntityFactory::createEntity(Friend::class, $friend);
            }
            return new EntityCollection($friends);
        }
        throw new ResponseException("Response Error");
    }
}
