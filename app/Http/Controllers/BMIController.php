<?php
/**
 * 身体质量指数计算
 * @author mybsdc <mybsdc@gmail.com>
 * @date 2019/4/13
 * @time 10:19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BMIController extends Controller
{
    public function index()
    {
        return view('BMI.index');
    }

    public function calcBmi(Request $request)
    {
        $sex = $request->post('sex');
        $height = $request->post('height');
        $weight = $request->post('weight');
        $qq = $request->post('qq', '');
        $clientIp = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $request->getClientIp();
        Log::info(sprintf('[ip] %s [request] ', $clientIp), [
            'sex' => $sex === '0' ? '女' : ($sex === '1' ? '男' : '保密'),
            'height' => $height,
            'weight' => $weight,
            'qq' => $qq
        ]);

        if (!is_numeric($sex)) {
            Log::error('sex参数非法：' . $sex);
            return response()->json([
                'code' => 9,
                'msg' => trans('msg.common.invalidArg'),
                'systemDate' => date('Y-m-d H:i:s')
            ]);
        }

        if (!is_numeric($height)) {
            Log::error('height参数非法：' . $height);
            return response()->json([
                'code' => 9,
                'msg' => trans('msg.bmi.heightInvalid'),
                'systemDate' => date('Y-m-d H:i:s')
            ]);
        }
        if (bccomp($height, 0) !== 1) {
            Log::error('height参数非法：' . $height);
            return response()->json([
                'code' => 9,
                'msg' => trans('msg.bmi.heightLt0'),
                'systemDate' => date('Y-m-d H:i:s')
            ]);
        }

        if (!is_numeric($weight)) {
            Log::error('weight参数非法：' . $weight);
            return response()->json([
                'code' => 9,
                'msg' => trans('msg.bmi.weightInvalid'),
                'systemDate' => date('Y-m-d H:i:s')
            ]);
        }
        if (bccomp($weight, 0) !== 1) {
            Log::error('weight参数非法：' . $weight);
            return response()->json([
                'code' => 9,
                'msg' => trans('msg.bmi.weightLt0'),
                'systemDate' => date('Y-m-d H:i:s')
            ]);
        }

        bcscale(2);

        $height = bcdiv($height, 100);
        $bmiVal = bcdiv($weight, bcpow($height, 2), 1);

        /**
         * 體重過輕：BMI < 18.5
         * 健康體位：18.5 <= BMI < 24
         * 過重：24 <= BMI < 27
         * 輕度肥胖：27 <= BMI < 30
         * 中度肥胖：30 <= BMI < 35
         * 重度肥胖：BMI >= 35
         */
        $color = '';
        $bmi = '';
        $tips = '';
        $imgURL = '';
        $sexName = $sex === '0' ? '小姑娘' : '小伙子';
        $range = '';
        if ($bmiVal < 18.5) {
            $color = '#999999';
            $bmi = '过轻';
            $tips = '你需要长胖';
            $range = 'BMI < 18.5';
        } else if ($bmiVal >= 18.5 && $bmiVal < 24) {
            $color = '#99CC33';
            $bmi = '标准身材';
            $tips = '恭喜，我从未见过身材如此标准的人';
            $range = '18.5 <= BMI < 24';
        } else if ($bmiVal >= 24 && $bmiVal < 27) {
            $color = '#FFCC00';
            $bmi = '过重';
            $tips = $sexName . '，你该减肥了，虽然你可能觉得你体重还有上升空间，只要你跑得足够快，脂肪就追不上你';
            $range = '24 <= BMI < 27';
        } else if ($bmiVal >= 27 && $bmiVal < 30) {
            $color = '#FF9900';
            $bmi = '轻度肥胖';
            $tips = $sexName . '，你该减肥了';
            $range = '27 <= BMI < 30';
        } else if ($bmiVal >= 30 && $bmiVal < 35) {
            $color = '#990033';
            $bmi = '中度肥胖';
            $tips = $sexName . '，你该减肥了';
            $range = '30 <= BMI < 35';
        } else if ($bmiVal >= 35) {
            $color = '#f83823';
            $bmi = '重度肥胖';
            $tips = '我从未见过如此胖重之人，长肥秘诀分享一下如何';
            $imgURL = 'https://ws1.sinaimg.cn/large/a4d9cbc6gy1g215he31kyj208z07xk14.jpg';
            $range = 'BMI >= 35';
        }

        $rt = [
            'code' => 0,
            'bmi' => sprintf('<span class="custom-badge" style="color: %s">%s</span>', $color, $bmi),
            'tips' => $tips,
            'bmiVal' => sprintf('<span class="custom-badge" style="color: %s">%s</span>', $color, $bmiVal),
            'imgURL' => $imgURL,
            'range' => sprintf('<span class="custom-badge" style="color: %s">%s</span>', $color, $range),
            'systemDate' => date('Y-m-d H:i:s')
        ];
        Log::info(sprintf('[ip] %s [response] ', $clientIp), $rt);

        return response()->json($rt);
    }
}