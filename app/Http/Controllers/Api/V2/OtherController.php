<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class OtherController extends BaseController
{

    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @api {get} /api/v2/other/config 系统配置
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.webname 网站名
     * @apiSuccess {String} data.icp ICP备案号
     * @apiSuccess {String} data.user_protocol 用户协议URL
     * @apiSuccess {String} data.user_private_protocol 用户隐私协议URL
     * @apiSuccess {String} data.aboutus 关于我们
     * @apiSuccess {String} data.logo LOGO的URL
     * @apiSuccess {Object} data.player 播放器
     * @apiSuccess {String} data.player.cover 播放器封面
     * @apiSuccess {Number} data.player.enabled_bullet_secret 开启跑马灯[1:是,0否]
     * @apiSuccess {Object} data.member
     * @apiSuccess {Number} data.member.enabled_mobile_bind_alert 强制绑定手机号[1:是,0否]
     * @apiSuccess {Number} data.socialites.qq QQ登录[1:是,0否]
     * @apiSuccess {Number} data.socialites.wechat_scan 微信扫码登录[1:是,0否]
     * @apiSuccess {Number} data.socialites.wechat_oauth 微信授权登录[1:是,0否]
     * @apiSuccess {Number} data.credit1_reward.register 注册送积分
     * @apiSuccess {Number} data.credit1_reward.watched_vod_course 看完录播课送积分
     * @apiSuccess {Number} data.credit1_reward.watched_video 看完视频
     * @apiSuccess {Number} data.credit1_reward.paid_order 支付订单[按订单金额比率奖励积分]
     * @apiSuccess {Number} data.credit1_reward.invite 邀请用户注册
     */
    public function config()
    {
        $plyaerConfig = $this->configService->getPlayer();

        $data = [
            // 网站名
            'webname' => $this->configService->getName(),
            // ICP备案
            'icp' => $this->configService->getIcp(),
            'icp_link' => $this->configService->getIcpLink(),
            // 公安网备案
            'icp2' => $this->configService->getIcp2(),
            'icp2_link' => $this->configService->getIcp2Link(),
            // 用户协议URL
            'user_protocol' => route('user.protocol'),
            // 用户隐私协议URL
            'user_private_protocol' => route('user.private_protocol'),
            // 关于我们URL
            'aboutus' => route('aboutus'),
            'logo' => $this->configService->getLogo(),
            'player' => [
                // 播放器封面
                'cover' => $this->configService->getPlayerCover(),
                // 跑马灯
                'enabled_bullet_secret' => $plyaerConfig['enabled_bullet_secret'] ?? 0,
            ],
            'member' => [
                // 强制绑定手机号
                'enabled_mobile_bind_alert' => $this->configService->getEnabledMobileBindAlert(),
            ],
            // 社交登录
            'socialites' => [
                'qq' => (int)$this->configService->getSocialiteQQLoginEnabled(),
                'wechat_scan' => (int)$this->configService->getSocialiteWechatScanLoginEnabled(),
                'wechat_oauth' => (int)$this->configService->getSocialiteWechatLoginEnabled(),
            ],
            // 积分奖励
            'credit1_reward' => [
                // 注册
                'register' => $this->configService->getRegisterSceneCredit1(),
                // 看完录播课
                'watched_vod_course' => $this->configService->getWatchedCourseSceneCredit1(),
                // 看完视频
                'watched_video' => $this->configService->getWatchedVideoSceneCredit1(),
                // 已支付订单[抽成]
                'paid_order' => $this->configService->getPaidOrderSceneCredit1(),
                // 邀请用户注册
                'invite' => $this->configService->getInviteSceneCredit1(),
            ],
        ];
        return $this->data($data);
    }
}
