<link rel="stylesheet" type="text/css" href="{?:C('CSS_PATH')?}jquery-ui.css">
<div class="fancy">
    <h3>编辑事件</h3>
    <form id="add_form" action="{?:U()?}" method="post">
        <input type="hidden" name="id" id="eventid" value="<?php echo $id;?>">
        <p>日程内容：<input type="text" class="input" name="event" id="event" style="width:320px" placeholder="记录你将要做的一件事..." value="<?php echo $title;?>"></p>
        <p>开始时间：<input type="text" class="input datepicker" name="startdate" id="startdate" value="<?php echo $start_d;?>" readonly>
    <span id="sel_start" <?php echo $display;?>><select name="s_hour">
            <option value="<?php echo $start_h;?>" selected><?php echo $start_h;?></option>
            <option value="00">00</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
        </select>:
    <select name="s_minute">
        <option value="<?php echo $start_m;?>" selected><?php echo $start_m;?></option>
        <option value="00">00</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50">50</option>
    </select>
    </span>
        </p>
        <p id="p_endtime" <?php echo $end_display;?>>结束时间：<input type="text" class="input datepicker" name="enddate" id="enddate" value="<?php echo $end_d;?>" readonly>
    <span id="sel_end"  <?php echo $display;?>><select name="e_hour">
            <option value="<?php echo $end_h;?>" selected><?php echo $end_h;?></option>
            <option value="00">00</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
        </select>:
    <select name="e_minute">
        <option value="<?php echo $end_m;?>" selected><?php echo $end_m;?></option>
        <option value="00">00</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50">50</option>
    </select>
    </span>
        </p>
        <p>
            <label><input type="checkbox" value="1" id="isallday" name="isallday" <?php echo $allday_chk;?>> 全天</label>
            <label><input type="checkbox" value="1" id="isend" name="isend" <?php echo $end_chk;?>> 结束时间</label>
        </p>
        <div class="sub_btn"><span class="del"><input type="button" class="btn btn_del" id="del_event" value="删除"></span><input type="submit" class="btn btn_ok" value="确定"> <input type="button" class="btn btn_cancel" value="取消" onClick="$.fancybox.close()"></div>
    </form>
</div>

<script type="text/javascript" src="{?:C('JS_PATH')?}jquery.form.min.js"></script>
<script type="text/javascript">
    $(function(){
        $(".datepicker").datepicker({minDate: -3,maxDate: 3});
        $("#isallday").click(function(){
            if($("#sel_start").css("display")=="none"){
                $("#sel_start,#sel_end").show();
            }else{
                $("#sel_start,#sel_end").hide();
            }
        });

        $("#isend").click(function(){
            if($("#p_endtime").css("display")=="none"){
                $("#p_endtime").show();
            }else{
                $("#p_endtime").hide();
            }
            $.fancybox.resize();//调整高度自适应
        });

        //提交表单
        $('#add_form').ajaxForm({
            beforeSubmit: showRequest, //表单验证
            success: showResponse //成功返回
        });

        //删除事件
        $("#del_event").click(function(){
            if(confirm("您确定要删除吗？")){
                var eventid = $("#eventid").val();
                $.post("{?:U('delete')?}",{id:eventid},function(msg){
                    if(msg==1){//删除成功
                        $.fancybox.close();
                        $('#calendar').fullCalendar('refetchEvents'); //重新获取所有事件数据
                    }else{
                        alert(msg);
                    }
                });
            }
        });
    });

    function showRequest(){
        var events = $("#event").val();
        if(events==''){
            alert("请输入日程内容！");
            $("#event").focus();
            return false;
        }
    }

    function showResponse(responseText, statusText, xhr, $form){
        if(statusText=="success"){
            if(responseText==1){
                $.fancybox.close();
                $('#calendar').fullCalendar('refetchEvents'); //重新获取所有事件数据
            }else{
                alert(responseText);
            }
        }else{
            alert(statusText);
        }
    }
</script>