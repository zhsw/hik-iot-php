<?php

namespace HikIot;

class HikApiClassMap
{
    private static $map = [
        // 授权
        'OAuth' => [
            'Token' => 'HikIot\\RestApi\\OAuth\\Token'
        ],

        // 分组管理（v2）
        'Groups' => [
            'Add' => 'HikIot\\RestApi\\Groups\\AddGroup',
            'Update' => 'HikIot\\RestApi\\Groups\\UpdateGroup',
            'Delete' => 'HikIot\\RestApi\\Groups\\DeleteGroup',
            'Info' => 'HikIot\\RestApi\\Groups\\GetGroup',
            'List' => 'HikIot\\RestApi\\Groups\\GroupList',
            'ChildrenList' => 'HikIot\\RestApi\\Groups\\ChildrenGroupList'
        ],

        // 设备管理
        'Devices' => [
            'Add' => 'HikIot\\RestApi\\Devices\\AddDevice',
            'Delete' => 'HikIot\\RestApi\\Devices\\DeleteDevice',
            'List' => 'HikIot\\RestApi\\Devices\\DeviceList',
            'Info' => 'HikIot\\RestApi\\Devices\\DeviceInfo',
            'Update' => 'HikIot\\RestApi\\Devices\\UpdateDevice',
            'Count' => 'HikIot\\RestApi\\Devices\\DeviceCount',
            'SetDefence' => 'HikIot\\RestApi\\Devices\\SetDeviceDefence',
            // 视频直播
            'Live' => [
                'EncryptOff' => 'HikIot\\RestApi\\Devices\\DeviceEncryptOff',
                'VideoOpen' => 'HikIot\\RestApi\\Devices\\LiveVideoOpen',
                'Address' => 'HikIot\\RestApi\\Devices\\LiveAddress',
                'AddressLimit' => 'HikIot\\RestApi\\Devices\\LiveAddressLimit',
            ],
        ],

        // 通道管理
        'Channels' => [
            'List' => 'HikIot\\RestApi\\Channels\\ChannelList',
            'Update' => 'HikIot\\RestApi\\Channels\\UpdateChannel',
            'Osd' => 'HikIot\\RestApi\\Channels\\ChannelOsd',
            'Capture' => 'HikIot\\RestApi\\Channels\\ChannelCapture',
            'SynchChannels' => 'HikIot\\RestApi\\Channels\\SynchDeviceChannels',
        ],
    ];

    /**
     * @param string $api_name
     * @return string|boolean
     */
    public static function getClassName(string $api_name)
    {
        $api_name = explode('.', $api_name);
        $api = self::$map;
        foreach ($api_name as $value) {
            if (!isset($api[$value])) {
                return false;
            }
            $api = $api[$value];
        }
        if (!is_string($api)) {
            return false;
        }
        return $api;
    }
}