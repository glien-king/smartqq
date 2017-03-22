<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Collection\Collection;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Client;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Utils;

class GetGroupsRequest extends Request
{
    protected $url = 'http://s.web2.qq.com/api/get_group_name_list_mask2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', [
            'vfwebqq' => $credential->getPtWebQQ(),
            'hash' => Utils::hash($credential->getUin(), $credential->getPtWebQQ()),
        ]);
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @param Client $client
     * @return EntityCollection
     */
    public static function parseResponse(Response $response, Client $client)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $markNames = (new Collection($jsonData['result']['gmarklist']))->combine('uin', 'markname');
            $groups = [];
            foreach ($jsonData['result']['gnamelist'] as $groupData) {
                $groupId = $groupData['gid'];
                $groupData['id'] = $groupData['gid'];
                $groupData['markName'] = isset($markNames[$groupId]) ? $markNames[$groupId] : '';
                $group = EntityFactory::createGroup($groupData);
                $group->setClient($client);
                $groups[] = $group;
            }
            return new EntityCollection($groups);
        }
        throw new ResponseException("Response Error");
    }
}
