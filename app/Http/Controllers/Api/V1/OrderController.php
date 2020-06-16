<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Models\Goods;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     *  创建订单
     */
    public function create(Request $request)
    {
        try{
            $goods = $request->input('goods', []);
            if (empty($goods)) return $this->response(400, '未选择商品');
            $total_money = 0;
            foreach ($goods as $val)
            {
                if ($val['num'] <= 0) return $this->response(400, '下单商品数量必须大于0');
                $temp_goods = Goods::where('status', 1)->where('id', $val['goods_id'])->first();
                if (empty($temp_goods)) return $this->response(400, '商品不存在或者已删除');
                if ($temp_goods->stock < $val['num']) return $this->response(400, '商品【' . $temp_goods->title . '】库存不足');
                $total_money += $temp_goods->price * $val['num'];
            }
            DB::beginTransaction();
            // 创建订单
            $data_order = [
                'user_id' => $request->user->id,
                'total_money' => $total_money,
                'pay_money' => $total_money,
                'order_sn' => date('YmdHis') . mt_rand(1000, 9999)
            ];
            if (empty($order = Order::create($data_order)))
            {
                DB::rollBack();
                return $this->response(400, '订单创建失败');
            }
            foreach ($goods as $val)
            {
                $temp_goods = Goods::where('status', 1)->where('id', $val['goods_id'])->first();
                // 创建订单详情
                $data_detail = [
                    'order_id' => $order->id,
                    'goods_id' => $val['goods_id'],
                    'price' => $temp_goods->price,
                    'num' => $val['num'],
                    'title' => $temp_goods->title
                ];
                if (empty(OrderDetail::create($data_detail))) {
                    DB::rollBack();
                    return $this->response(400, '订单详情创建失败');
                }
                // 更新商品库存
                $temp_goods->stock = $temp_goods->stock - $val['num'];
                if (empty($temp_goods->save()))
                {
                    DB::rollBack();
                    return $this->response(400, '库存更新失败');
                }
            }
            DB::commit();
            return $this->response(200, '创建成功', ['order_sn' => $order->order_sn]);
        }catch (\Throwable $e) {
            DB::rollBack();
            return $this->response(500, $e->getMessage());
        }
    }

    /**
     * 订单支付
     */

}
