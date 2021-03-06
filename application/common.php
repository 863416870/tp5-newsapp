<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function paginator($obj)
{
   if(!$obj)
   {
       return '';
   }
   $params=request()->param();
   return '<div class="imooc-app">'.$obj->appends($params)->render().'</div>';
}

/**
 * 显示是否推荐
 * @param $value
 * @return string
 */
function isPosition($value)
{
  return $value?"<span style='color: red'>是</span>":"<span>否</span>";
}

/**
 * 显示分类名称
 * @param $value
 * @return mixed
 */
function catnameBycatid($value)
{
        $category = config('cats.lists');
        return $category[$value];
}
/**
 * 通用化修改状态
 *
 **/
function modifyStatus($id,$status)
{
      $request=\think\Request::instance();
      $controllerName=$request->controller();
      if($status===0)
      {
          $status=config('admin.status_normal');
      }
      else
      {
          $status=config('admin.status_padding');
      }
      $url=url($controllerName.'/changeStatus',['id'=>$id,'status'=>$status]);
//      由于上面修改过了status的值，所以这里全部逻辑取反
    $str='';
      if($status===0)
      {
//      这里是原来状态正常
        $str="<a href='javaScript:;' title='修改状态' status-url='".$url."' onclick='article_status(this)'><span class='label label-success radius'>正常</span></a>";
      }
      else if($status===1){
//          这里是原来状态待审
          $str="<a href='javaScript:;'  title='修改状态' status-url='".$url."' onclick='article_status(this)'><span class='label label-danger radius'>待审</span></a>";
      }
     return $str;
}

/**
 * 通用化API接口返回json
 * @param int $status 业务状态码
 * @param string $message 传递消息
 * @param array $data 传递数据
 * @param int $httpCode HTTP状态码
 */
function showJson($status,$message,$data=[],$httpCode=200)
{
     $dataJson=[
         'status'=>$status,
         'message'=>$message,
         'data'=>$data,
     ];
     return json($dataJson,$httpCode);
}
function showSex($value)
{
   if($value==0)
   {
       return '保密';
   }
    else if($value==1)
    {
        return '男';
    }
    else
    {
        return '女';
    }
}
