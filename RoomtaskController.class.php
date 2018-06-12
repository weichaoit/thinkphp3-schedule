<?php
/**
 * Created by PhpStorm.
 * User: weichao
 * Date: 2016/10/17
 * Time: 13:39
 */

namespace Admin\Controller;


use Think\Controller;

class RoomtaskController extends AdminController
{
    /**
     * @var \Admin\Model\RoomtaskModel
     */
    private $_model = null;

    /**
     * 初始化控制器
     */
    protected function _initialize(){
        $this->_model = D('Roomtask');
    }

    // 显示录音室日程管理主页
    public function index(){
        $this->display();
    }

    /**
     * 拖拽操作
     */
    public function drag(){
        if(IS_POST){
            if($this->_model->dragAct() === false){
                echo '出错了!';exit;
            }else{
                echo 1;
            }
        }
    }

    /**
     * 调整大小
     */
    public function resize(){
        if(IS_POST){
            if($this->_model->resizeAct() === false){
                echo '出错了!';exit;
            }else{
                echo 1;
            }
        }
    }

    /**
     * 页面需要的json数据
     */
    public function json(){
        //获取数据
        $data = $this->_model->jsonAct();
        echo json_encode($data);
    }

    /**
     * 添加日程的方法
     */
    public function add(){
        if(IS_POST){
            // 添加操作方法
            if($this->_model->addAct() === false){
                echo '写入失败';
            }else{
                echo 1;
            }
        }else{
            // 添加操作行为
            $date = $_GET['date'];
            $enddate = isset($_GET['end'])?$_GET['end']:"";
            if($date==$enddate) $enddate='';
            if(empty($enddate)){
                $display = 'style="display:none"';
                $chk = '';
            }else{
                $display = 'style=""';
                $chk = 'checked';
            }
            $enddate = empty($_GET['end'])?$date:$_GET['end'];
            $this->assign([
                'display'=>$display,
                'chk'=>$chk,
                'enddate'=>$enddate,
                'date'=>$date,
            ]);
            $this->display();
        }
    }

    /**
     * 编辑日程事件
     */
    public function edit(){
        if(IS_POST){
            if($this->_model->editAct() === false){
                echo '修改失败';
            }else{
                echo 1;
            }
        }else{
            $id = isset($_GET['id'])?intval($_GET['id']):0;

            $row = $this->_model->where(['id'=>$id])->find();
            if($row){
                $id = $row['id'];
                $title = $row['title'];
                $starttime = $row['starttime'];
                $start_d = date("Y-m-d",$starttime);
                $start_h = date("H",$starttime);
                $start_m = date("i",$starttime);

                $endtime = $row['endtime'];
                if($endtime==0){
                    $end_d = 0;
                    $end_chk = '';
                    $end_display = "style='display:none'";
                }else{
                    $end_d = date("Y-m-d",$endtime);
                    $end_h = date("H",$endtime);
                    $end_m = date("i",$endtime);
                    $end_chk = "checked";
                    $end_display = "style=''";
                }

                $allday = $row['allday'];
                if($allday==1){
                    $display = "style='display:none'";
                    $allday_chk = "checked";
                }else{
                    $display = "style=''";
                    $allday_chk = '';
                }
            }
            $this->assign([
                'id'=>$id,
                'title'=>$title,
                'start_d'=>$start_d,
                'start_h'=>$start_h,
                'start_m'=>$start_m,
                'end_d'=>$end_d,
                'end_chk'=>$end_chk,
                'end_display'=>$end_display,
                'end_h'=>$end_h,
                'end_m'=>$end_m,
                'display'=>$display,
                'allday_chk'=>$allday_chk,
            ]);
            $this->display();
        }
    }

    /**
     * 删除日程事件
     * @param $id
     */
    public function delete($id){
        if($this->_model->delete($id) === false){
            echo '删除失败';
        }else{
            echo 1;
        }
    }
}