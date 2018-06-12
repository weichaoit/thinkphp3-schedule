<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="{?:C('CSS_PATH')?}common.css" />
        <link rel="stylesheet" type="text/css" href="{?:C('CSS_PATH')?}fullcalendar.css"/>
        <link rel="stylesheet" type="text/css" href="{?:C('CSS_PATH')?}fancybox.css"/>
        <style type="text/css">
            .demo{width:980px}
            #calendar{width:960px; margin:20px auto 0}
            .fancy{width:450px; height:auto}
            .fancy h3{height:30px; line-height:30px; border-bottom:1px solid #d3d3d3; font-size:14px}
            .fancy form{padding:10px}
            .fancy p{height:28px; line-height:28px; padding:4px; color:#999}
            .input{height:20px; line-height:20px; padding:2px; border:1px solid #d3d3d3; width:100px}
            .btn2{-webkit-border-radius: 3px;-moz-border-radius:3px;padding:5px 12px; cursor:pointer}
            .btn_ok{background: #360;border: 1px solid #390;color:#fff}
            .btn_cancel{background:#f0f0f0;border: 1px solid #d3d3d3; color:#666 }
            .btn_del{background:#f90;border: 1px solid #f80; color:#fff }
            .sub_btn{height:32px; line-height:32px; padding-top:6px; border-top:1px solid #f0f0f0; text-align:right; position:relative}
            .sub_btn .del{position:absolute; left:2px}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="demo">
                <div id='calendar'></div>
            </div>
        </div>
        <div class="foot">
        </div>
        <script type="text/javascript" src="__JS__/jquery.min.js"></script>
        <script src="{?:C('JS_PATH')?}jquery-ui.js"></script>
        <script src="{?:C('JS_PATH')?}fullcalendar.min.js"></script>
        <script src="{?:C('JS_PATH')?}jquery.fancybox-1.3.1.pack.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: true,
                    dragOpacity: {
                        agenda: .5,
                        '': .6
                    },
                    eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {
                        $.post("{?:U('drag')?}", {id: event.id, daydiff: dayDelta, minudiff: minuteDelta, allday: allDay}, function(msg) {
                            if (msg != 1) {
                                alert(msg);
                                revertFunc();
                            }
                        });
                    },
                    eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
                        $.post("{?:U('resize')?}", {id: event.id, daydiff: dayDelta, minudiff: minuteDelta}, function(msg) {
                            if (msg != 1) {
                                alert(msg);
                                revertFunc();
                            }
                        });
                    },
                    selectable: true,
                    select: function(startDate, endDate, allDay, jsEvent, view) {
                        var start = $.fullCalendar.formatDate(startDate, 'yyyy-MM-dd');
                        var end = $.fullCalendar.formatDate(endDate, 'yyyy-MM-dd');
                        $.fancybox({
                            'type': 'ajax',
                            'href': "{?:U('add')?}&date=" + start + "&end=" + end
                        });
                    },
                    events: "{?:U('json')?}",
                    dayClick: function(date, allDay, jsEvent, view) {
                        var selDate = $.fullCalendar.formatDate(date, 'yyyy-MM-dd');
                        $.fancybox({
                            'type': 'ajax',
                            'href': "{?:U('add')?}&date="+selDate
                        });
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        $.fancybox({
                            'type': 'ajax',
                            'href': "{?:U('edit')?}&id=" + calEvent.id
                        });
                    }
                });
            });
        </script>
    </body>
</html>

