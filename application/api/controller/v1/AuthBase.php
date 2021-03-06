<?php
/**
 * Create By guaosi
 * Author guaosi
 * Date: 2017/11/2/0002
 * Time: 15:26
 */
namespace app\api\controller\v1;
use app\api\controller\Common;
use app\common\lib\Aes;
use app\lib\exception\IsLoginException;
use app\admin\model\User as Usermodel;
class AuthBase extends  Common
{
    protected $user;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        if(!$this->isLogin())
        {
            throw new IsLoginException();
        }
    }

    /**
     * 判断用户是否已经登陆
     * @return bool
     */
    public function isLogin()
    {
//        是否传递access-user-token
          if (empty($this->header['access-user-token']))
          {
              return false;
          }
          $access_user_token=(new Aes())->decrypt($this->header['access-user-token']);
//          access-user-token格式是否正确
          if(!preg_match('/||/',$access_user_token))
          {
              return false;
          }
          list($token,$id)=explode('||',$access_user_token);
//        access-user-token是否存在
          $user=Usermodel::where('token',$token)->find();
          if(empty($user))
          {
              return false;
          }
//          access-user-token是否过期
          if($user->time_out<time())
          {
              return false;
          }
          $this->user=$user;
          return true;
    }
}