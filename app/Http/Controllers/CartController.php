<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Order_details;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name');
        
        if($name){
            $orders = Order::where('name','like','%'.$name.'%') 
            ->paginate(5);
        }else{ 
            $orders = Order::select('id', 'email', 'address', 'phone',  'price', 'note', 'status', 'created_at', 'user_id' )
            ->paginate(5);
        } 
        return view('admin.cart.list', [
            'orders' => $orders,  
            'name' => $name, 
        ]);
    }
    public function changeStatus(Request $request)
    { 
        $orders = Order::find($request->id); 
        $orders->status = $request->status; 
        $orders->save(); 
        return response()->json(['success'=>'Status change successfully.']); 
    } 
    public function details(Request $request, Order $order)
    {
        $order_id = $order->id;
        // $name = $request->get('name');
        // if($name){
        //     $order_details = Order_details::where('name','like','%'.$name.'%') 
        //     ->paginate(5);
        // }else{ 
            $order_details = Order_details::select('id','product_name','product_price','Total_money','amount','order_id','product_id','product_img')
            ->where('order_id', '=',  $order_id)
            ->paginate(5);
        // }
        return view('admin.cart.details', [
            'order_details' => $order_details,  
            // 'name' => $name, 
        ]);
    }
    public function delete(Order $order) {
        // $order_id = $order->id;
        // $order_details = Order_details::where('order_id', '=',  $order_id)->get();
        // $order_details->delete();
        if($order->delete()) {
        
            return redirect()->back();
        }
    }
}
