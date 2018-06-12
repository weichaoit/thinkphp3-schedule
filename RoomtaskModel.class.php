<?php
/**
 * Created by PhpStorm.
 * User: weichao
 * Date: 2016/10/17
 * Time: 13:56
 */

namespace Admin\Model;


use Think\Model;

class RoomtaskModel extends Model
{
    protected $trueTableName = 'site_calendar';

    /**
     * 拖拽方法
     * @return bool
     */
    public function dragAct(){
        $id = I('post.id');
        $daydiff = (int) I('post.daydiff') * 24 * 60 * 60;
        $minudiff = (int) I('post.minudiff') * 60;
        $allday = I('post.allday');

        $row = $this->where(['id'=>$id])->find();
        if ($allday == "true") {
            if ($row['endtime'] == 0) {
                $sql = "update `site_calendar` set starttime=starttime+'$daydiff' where id='$id'";
            } else {
                $sql = "update `site_calendar` set starttime=starttime+'$daydiff',endtime=endtime+'$daydiff' where id='$id'";
            }
        } else {
            $difftime = $daydiff + $minudiff;
            if ($row['endtime'] == 0) {
                $sql = "update `site_calendar` set starttime=starttime+'$difftime' where id='$id'";
            } else {
                $sql = "update `site_calendar` set starttime=starttime+'$difftime',endtime=endtime+'$difftime' where id='$id'";
            }
        }
        $result = $this->execute($sql);
        if ($result == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 重置大小
     * @return bool
     */
    public function resizeAct(){
        $id = I('post.id');
        $daydiff = (int) I('post.daydiff') * 24 * 60 * 60;
        $minudiff = (int) I('post.minudiff') * 60;

        $row = $this->where(['id'=>$id])->find();
        $difftime = $daydiff + $minudiff;
        if ($row['endtime'] == 0) {
            $sql = "update `site_calendar` set endtime=starttime+'$difftime' where id='$id'";
        } else {
            $sql = "update `site_calendar` set endtime=endtime+'$difftime' where id='$id'";
        }

        $result = $this->execute($sql);
        if ($result == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 首页面需要的json数据
     * @return array
     */
    public function jsonAct(){

        $rows = $this->select();
        $data = [];
        foreach($rows as $row){
            $allday = $row['allday'];
            $is_allday = $allday == 1 ? true : false;

            $data[] = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'start' => date('Y-m-d H:i', $row['starttime']),
                'end' => date('Y-m-d H:i', $row['endtime']),
                'allDay' => $is_allday,
                'color' => $row['color']
            );
        }
        return $data;
    }

    /**
     * 添加方法
     * @return bool
     */
    public function addAct(){
        $events = stripslashes(trim(I('post.event'))); //事件内容

        $isallday = I('post.isallday'); //是否是全天事件
        $isends = I('post.isend');
        $isend = isset($isends) ? $isends : ""; //是否有结束时间

        $startdate = trim(I('post.startdate')); //开始日期
        $enddate = trim(I('post.enddate')); //结束日期

        $s_time = I('post.s_hour') . ':' . I('post.s_minute') . ':00'; //开始时间
        $e_time = I('post.e_hour') . ':' . I('post.e_minute') . ':00'; //结束时间
        $endtime = 0;
        if ($isallday == 1 && $isend == 1) {
            $starttime = strtotime($startdate);
            $endtime = strtotime($enddate);
        } elseif ($isallday == 1 && $isend == "") {
            $starttime = strtotime($startdate);
        } elseif ($isallday == "" && $isend == 1) {
            $starttime = strtotime($startdate . ' ' . $s_time);
            $endtime = strtotime($enddate . ' ' . $e_time);
        } else {
            $starttime = strtotime($startdate . ' ' . $s_time);
        }

        $colors = array("#360", "#f30", "#06c");
        $key = array_rand($colors);
        $color = $colors[$key];

        $isallday = $isallday ? 1 : 0;
        $sql = "insert into `site_calendar` (`title`,`starttime`,`endtime`,`allday`,`color`) values ('$events','$starttime','$endtime','$isallday','$color')";
        $query = $this->execute($sql);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改方法
     * @return bool
     */
    public function editAct(){
        $id = intval(I('post.id'));
        if ($id == 0) {
            return false;
            exit;
        }
        $events = stripslashes(trim(I('post.event'))); //事件内容

        $isallday = I('post.isallday'); //是否是全天事件
        $isend = I('post.isend'); //是否有结束时间

        $startdate = trim(I('post.startdate')); //开始日期
        $enddate = trim(I('post.enddate')); //结束日期

        $s_time = I('post.s_hour') . ':' . I('post.s_minute') . ':00'; //开始时间
        $e_time = I('post.e_hour') . ':' . I('post.e_minute') . ':00'; //结束时间

        if ($isallday == 1 && $isend == 1) {
            $starttime = strtotime($startdate);
            $endtime = strtotime($enddate);
        } elseif ($isallday == 1 && $isend == "") {
            $starttime = strtotime($startdate);
            $endtime = 0;
        } elseif ($isallday == "" && $isend == 1) {
            $starttime = strtotime($startdate . ' ' . $s_time);
            $endtime = strtotime($enddate . ' ' . $e_time);
        } else {
            $starttime = strtotime($startdate . ' ' . $s_time);
            $endtime = 0;
        }

        $isallday = $isallday ? 1 : 0;
        $sql = "update `site_calendar` set `title`='$events',`starttime`='$starttime',`endtime`='$endtime',`allday`='$isallday' where `id`='$id'";
        $setId = $this->execute($sql);
        if ($setId) {
            return true;
        } else {
            return false;
        }
    }
}