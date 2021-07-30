<?php


namespace App\Plugins\Core\src\Controller\User;


use App\Plugins\Core\src\Request\User\Mydata\JibenRequest;
use App\Plugins\User\src\Mail\RePwd;
use App\Plugins\User\src\Middleware\LoginMiddleware;
use App\Plugins\User\src\Models\UserRepwd;
use Exception;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\RequestMapping;
use HyperfExt\Hashing\Hash;
use HyperfExt\Mail\Mail;
use Illuminate\Support\Str;

#[Controller]
#[Middleware(LoginMiddleware::class)]
class IndexController
{
    #[GetMapping(path: "/user/setting")]
    public function user_setting(): \Psr\Http\Message\ResponseInterface
    {
        return view("plugins.Core.user.setting");
    }

    #[PostMapping(path: "/user/data")]
    public function my_data()
    {
        return auth()->data();
    }

    // 更新个人信息
    #[RequestMapping(method: "POST,HEAD",path: "/user/myUpdate")]
    public function myUpdate(JibenRequest $request)
    {
        if(!$request->input("old_pwd") || !$request->input("new_pwd")){
            return redirect()->back()->with("info","无修改")->go();
        }
        $old_pwd = $request->input("old_pwd");
        $new_pwd = $request->input("new_pwd");
        if(!Hash::check($old_pwd,auth()->data()->password)){
            return redirect()->back()->with("danger","旧密码错误")->go();
        }
        $pwd = Hash::make($new_pwd);
        $data = UserRepwd::query()->create([
            "user_id" => auth()->data()->id,
            "pwd" => $pwd,
            "hash" => Str::random()
        ]);
        $user = auth()->data();
        go(static function() use($data,$user){
            $url = url("/user/myUpdate/ConfirmPassword/".$data->id."/".$data->hash);
            $mail = Email();
            $mail->addAddress($user->email);
            $mail->Subject = "【".get_options("web_name")."】修改密码确认";
            $mail->Body    = <<<HTML
你好 {$user->username},<br>
你在本网站修改了用户密码,安全起见点击以下链接确认修改:<br>
<a href="{$url}">{$url}</a>
HTML;
            $mail->send();
        });
        return redirect()->back()->with('success','修改密码邮件已发送至你的邮箱')->go();

    }

    /**
     * @throws Exception
     */
    #[GetMapping(path: "/test")]
    public function test()
    {
        return request()->fullUrl();
        return "ok";
    }
}