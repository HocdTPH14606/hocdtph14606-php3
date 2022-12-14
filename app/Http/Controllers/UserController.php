<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $room = room::find(1); 
        // $roomChildren = $room->children; // gọi phương thức quan hệ tới model room
        // $roomParent = $room->oneParent;
        // dd($room, $roomParent);
        // Lấy ra toàn bộ bản ghi trong DB bảng users
        // $users = User::all();
        $name = $request->get('name');
        if($name){
            $users = User::where('name','like','%'.$name.'%')
        // ->where('id', '>', 3) 
        ->with('room') 
        ->paginate(5);
        }else{
            $users = User::select('id', 'name', 'birthday', 'username', 'email', 'avatar', 'status', 'role','room_id')
            // ->get();
        // ->where('id', '>', 3)
        // (tên trường, toán tử điều kiện, giá trị)
        ->with('room') // truy vấn thêm quan hệ trước khi truy vấn 
        // ->where('id', '<=', 7)
        ->paginate(5);
        // ->cursorPaginate(5); truy vấn where id > 5 limit 5
        // dd($users);
        }   

        return view('admin.user.list', ['user_list' => $users, 'name' => $name]);
    }

    // public function delete($id) {
    //     // Cách 1
    //     // if ($id) {
    //     //     $user = User::find($id);
    //     //     if ($user->delete()) {
    //             // return redirect()->route('users.list');
    //     //     }
    //     // }

    //     // Cách 2
    //     if($id) {
    //         if(User::destroy($id)) {
    //             return redirect()->back();
    //         }
    //     }
    // }
    // Cách 3
    public function delete(User $user) {
        if($user->delete()) {
            return redirect()->back();
        }
    }

    public function create()
    {
        // 1. Lấy ra danh sách room để bên view select
        $rooms = Room::where('parent_id', '=', 2 )->get();
        // 2. Trả về view kèm dữ liệu room
        return view('admin.user.create', [
            'rooms' => $rooms
        ]);
    }

    private function saveFile($file, $prefixName = '', $folder = 'public')
    {
        $fileName = $file->hashName();
        $fileName = $prefixName
            ? $prefixName . '_' . $fileName
            : $fileName;

        return $file->storeAs($folder, $fileName);
    }

    public function store(UserUpdateRequest $request)
    {
        // 0. Định nghĩa các điều kiện dữ liệu phù hợp để kiểm tra
        $request->validate([
            'name' => 'required|min:6|max:32',
            'email' => 'required|min:6|max:32|email',
            'avatar' => 'file',
            'birthday' => 'required|date'
        ]);
        // Nếu không đáp ứng các điều kiện trên thì
        // thoát hàm và quay lại form kèm thêm biến lỗi ($errors)

        // Nếu đáp ứng được điều kiện thì sẽ chạy tiếp xuống code bên dưới


        // 1. Khởi tạo đối tượng user mới
        $user = new User();
        // 2. Cập nhật giá trị cho các thuộc tính của $user
        // $user->name = $request->name;
        // $user->phone = $request->phone;
        $user->fill($request->all()); // đặt name ở form cùng giá trị với thuộc tính
        // 3. Xử lý file avatar gửi lên
        if($request->hasFile('avatar')) {
            // Nếu trường avatar có file thì sẽ trả về true
            // 3.1 Xử lý tên file
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = $request->username . '_' . $avatarName;
            // dd($avatar->storeAs('images/users', $avatarName));
            // 3.2 Lưu file và gán đường dẫn cho $user->avatar
            $user->avatar = $avatar->storeAs('images/users', $avatarName);
            // storage/app/images/users
            // Cấu hình config/filesystems.php để public/images ~ storage/app/images
            // Chạy câu lệnh: php artisan storage:link
        } else {
            $user->avatar = '';
        }
        // 4. Lưu
        $user->save();

        return redirect()->route('users.list');
        // Lab: Thực hiện chức năng chỉnh sửa, method PUT, có dữ liệu của user hiện tại và lưu

    }

    public function edit(User $user)
    {
        $user->birthday = date('Y-m-d', strtotime($user->birthday));
        $rooms = Room::select('id', 'name')->get();
        return view('admin.user.create', [
            'user' => $user,
            'rooms' => $rooms,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user) {
        $user->fill($request->except('password'));

        if($request->hasFile('avatar')) {
            $user->avatar = $this->saveFile(
                $request->avatar,
                $request->name,
                'images/users/'
            );
        }
        if($request->password) {
            $user->password = $request->password;
        }

        $user->save();
        return redirect()->route('users.list');
    }
    public function changeStatus(Request $request)

    { 
        $User = User::find($request->id); 
        $User->status = $request->status; 
        $User->save(); 
        return response()->json(['success'=>'Status change successfully.']); 
    } 
}
