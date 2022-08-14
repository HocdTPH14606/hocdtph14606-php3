<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Product;
use App\Models\Room;
use App\http\Requests\CommentRequest; 
use App\http\Requests\CartRequest; 
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name');
        $rooms = Room::select('id', 'name')->where('id', '>', 4)->get(); 
        if($name){
            return view('client.layout.shop', 
                [    
                    'name' => $name,  
                ]); 
        }else{ 
            $products = Product::select('id', 'name', 'price', 'thumbnail_url', 'status', 'room_id')
            ->where('status', '=', 1)
            ->paginate(8); 
            return view('client.layout.home', 
                [   'rooms' => $rooms,
                    'name' => $name,
                    'products' => $products 
                ]);
        } 
        
    }
    public function shop(Request $request)
    {
        $name = $request->get('name');
        $rooms = Room::select('id', 'name')->where('id', '>', 4)->get(); 
        
        if($name){
            $products = Product::where('name','like','%'.$name.'%') 
            ->paginate(9);
        }else{ 
            $products = Product::select('id', 'name', 'price', 'thumbnail_url', 'status', 'room_id')
            ->where('status', '=', 1)
            ->paginate(9);
        } 
        
        return view('client.layout.shop', 
        [  
             'rooms' => $rooms,
             'name' => $name,
            'products' => $products 
        ]); 
    } 
    public function contact()
    {
        return view('client.layout.contact');
    }
    public function detail(Product $product, Request $request)
    {    
        $name = $request->get('name');
        $rooms = Room::select('id', 'name') 
        ->where('id', '>', 4)
        ->get(); 
        $comment = Comment::select('id', 'userName','content','user_id','product_id', 'updated_at')
        ->where('product_id', '=', $product->id)
        ->get();
 
        if($name){
            return view('client.layout.shop', 
                [    
                    'name' => $name,  
                ]); 
        }else{
            $product_s = Product::select('id', 'name', 'price', 'thumbnail_url','status', 'room_id')
                ->where('status', '=', 1)
                ->where('room_id', '=', $product->room_id)
                ->get();
                //  dd($product_s);
            return view('client.layout.detail', [
                'product' => $product,
                'rooms' => $rooms,
                'name' => $name,
                'product_s' => $product_s,
                'comment' => $comment 
            ]);
        }
    }

    public function createComment(CommentRequest $request)
    {  
        $comment = new Comment(); 
        $comment->fill($request->all());
        $comment->save();
        return redirect()->back();
    } 
    public function commentDelete(Comment $comment) {
        if($comment->delete()) {
            return redirect()->back();
        }
    } 
    
    // public function commentEdit(Comment $comment)
    // {  
    //     $comment = $comment;
    //     return redirect()->back(); 
    // }  
    // public function commentUpdate(Request $request, Comment $comment) { 
    //     $comment->fill($request->except('->id')); 
    //     $comment->save();
    //     return redirect()->back();
    // }
    public function productRoom(Room $room)
    {
        $rooms = Room::select('id', 'name')->where('id', '>', 4)
        ->get(); 
        // $products = Product::select('id', 'name', 'price', 'thumbnail_url', 'status', 'room_id')->paginate(9);
        $products = Product::select('id', 'name', 'price', 'thumbnail_url', 'room_id')
        ->with('room')
        ->where('room_id', '=', $room->id)
        ->paginate(9);
        return view('client.layout.shop', 
        [   'rooms' => $rooms,
            'products' => $products 
        ]); 
    }
    public function AddCart(Request $request)
    { 
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [] ;  // Nếu giỏ hàng chưa tồn tại thì tạo mới và ngược lại 
            $product_name = $_POST['product_name'];
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];
            $product_price = $_POST['product_price'];
            $product_img = $_POST['product_img']; 
            $Total = $amount*$product_price;
                $cc = 0; //kiem tra sp co trong gio hang hay khong?

                for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                    if ($_SESSION['cart'][$i][1] == $product_name) {
                        $cc = 1;
                        $soluongnew = $amount + $_SESSION['cart'][$i][3];
                        $_SESSION['cart'][$i][3] = $soluongnew; 
                        $_SESSION['cart'][$i][4] = $soluongnew*$product_price;
                    }
                } 
                //neu khong trung sp trong gio hang thi them moi
                if ($cc == 0) { 
                    //them moi sp vao gio hang
                    $sp = [$product_img, $product_name, $product_price, $amount, $Total, $product_id];
                    $_SESSION['cart'][] = $sp;
                }
            // dd($_SESSION['cart']);
            return redirect()->route('client.cart');
    }
    public function cart(Request $request){
        $name = $request->get('name');
        $rooms = Room::select('id', 'name')->where('id', '>', 4)->get(); 
        if($name){
            return view('client.layout.shop', 
                [    
                    'name' => $name,  
                ]); 
        }else if(isset($_SESSION['cart'])){  
            // unset($_SESSION['cart']);
            // dd($_SESSION['cart']);
            return view('client.layout.cart', [  
                 'ttgh' => "", 
                 'tong' => 0,
                'cart' => $_SESSION['cart'],
                'name' => $name,  
                'rooms' => $rooms,
             ]);
        }else{
            return view('client.layout.cart', [   
               'name' => $name,  
               'rooms' => $rooms,
            ]);
        }
    } 
    public function cartDelete($delid) { 
        if (isset($delid) && ($delid >= 0)) { 
            array_splice($_SESSION['cart'], $delid, 1);
            //xóa sp trong giỏ hàng
            // dd($delid);
        } 
        return redirect()->back();
    }  
    public function cartDeleteAll() { 
        unset($_SESSION['cart']);
        //xóa hết  
        return redirect()->back();
    }
    public function checkout(Request $request)
    {
        $name = $request->get('name');
        $rooms = Room::select('id', 'name')->where('id', '>', 4)->get(); 
        if($name){
        return view('client.layout.shop', 
            [    
                'name' => $name,  
            ]); 
        }else if(isset($_SESSION['cart'])){   
            return view('client.layout.checkout', [  
                    'ttgh' => "", 
                    'tong' => 0,
                    'cart' => $_SESSION['cart'],
                    'name' => $name,  
                    'rooms' => $rooms,
                ]);
        }else{
            return view('client.layout.checkout', [   
                'name' => $name,  
                'rooms' => $rooms,
            ]);
        } 
    } 
    public function order(CartRequest $request,){
        $order = new Order();   
        $order->fill($request->all());  
        $order->save(); 
        if(isset($_SESSION['cart'])){   
            for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                $Order_details = new Order_details();    
        
                $Order_details->product_img = $_SESSION['cart'][$i][0];
                $Order_details->product_name = $_SESSION['cart'][$i][1];
                $Order_details->product_price = $_SESSION['cart'][$i][2];
                $Order_details->amount = $_SESSION['cart'][$i][3];
                $Order_details->Total_money = $_SESSION['cart'][$i][4]; 
                $Order_details->product_id = $_SESSION['cart'][$i][5]; 
                $Order_details->order_id = $order->id; 
                    
                    $Order_details->save();   
                } 
        } 
        unset($_SESSION['cart']);
        // dd($Order_details);
        return redirect()->route('client.client'); 
    }
} 