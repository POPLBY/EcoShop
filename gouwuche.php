
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>购物车</title>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
        .head1{
            width:100%;
            height:40px;
            background-color:#E6E6E6;
        }
        .head1 img{
            position:relative;
            top:6px;}
        .head1 a{
            text-decoration:none;
        }
        .body{
            margin-left:15%;
            margin-right:15%;
            background-color:#FFF;
            width:1450px;
        }
        .i1{
            width:300px;
        }
        .i2{
            width:250px;
            position:relative;
            right:-62%;
        }
        .c1{
            margin-top:80px}
        table{
            border:1px #666666 solid;
            width:100%;
            text-align:center;
            font-size:24px;
        }
        td{
            border:1px solid;
            border-color: #e3e3e3;
            border-top: 0px;
        }
        .zj{
            font-size: 40px;
            color: #e3221f;
        }
        a{
            text-decoration:none;
        }
        .jiesuan{
            background-color: #980000;
        }
        .jiesuan a{
            color: #eeeeee;
        }
        .bottom{
            position:fixed;
            bottom:0px;
            width: 100%;
        }
        input{
           padding: 5px;
            font-size: 17px;
            border-radius: 8px;
        }
        #tex{
            width: 40px;
            font-size: 20px;
            padding: 0px;
            border-radius: 1px;
        }
    </style>
    <script>
        //删除确认
        function del(){
            if(!window.confirm('是否要删除数据??'))
                return false;
        }
        //清空确认
        function qk(){
            if(!window.confirm('是否要清空购物车??'))
                return false;
        }
        //全部选择/取消
        function chek(){
            var leng = this.form1.chk.length;
            if(leng==undefined){
                leng=1;
                if(!form1.chk.checked)
                    document.form1.chk.checked=true;
                else
                    document.form1.chk.checked=false;
            }else{
                for( var i = 0; i < leng; i++)
                {
                    if(!form1.chk[i].checked)
                        document.form1.chk[i].checked = true;
                    else
                        document.form1.chk[i].checked = false;
                }
            }
            return false;
        }
    </script>
</head>
<body>
<div class="head1">
    <img src="images/gwc4.png"><a href="index.php">商城首页</a>
</div>
<div class="body">
    <div class="first"><img src="images/Logo.png" class="i1"><img src="images/gwc3.png" class="i2"></div>
    <hr/>
    <div class="c1">
        <h3>我的购物车</h3>
        <form name="form1" id="form1" method="post" action="deletegouwuche.php">
            <table  cellspacing="0" cellpadding="0" id="table1">
                <tr>
                    <td>选择</td>
                    <td>商品名称</td>
                    <td>数量</td>
                    <td>市场单价</td>
                    <td>会员单价</td>
                    <td>小计</td>
                    <td>操作</td>
                </tr>
                <?php
                include ('conn/conn.php');
                $Db = new connDB('localhost', 'root', '', 'db_ecoshop', '3308', 'utf-8');
                $conn = $Db->getConnect();
                $sqlstr = "SELECT * FROM `tb_gouwuche` order by id"; //定义查询语句
                $pagesize = 4 ;									//每页显示记录数
                $total = mysqli_query($conn,$sqlstr);//执行查询语句
                $totalNum = mysqli_num_rows($total);					//总记录数
                $pagecount = ceil($totalNum/$pagesize);						//总页数
                (!isset($_GET['page']))?($page = 1):$page = $_GET['page'];				//当前显示页数
                ($page <= $pagecount)?$page:($page = $pagecount);//当前页大于总页数时把当前页定义为总页数
                $f_pageNum = $pagesize * ($page - 1);								//当前页的第一条记录
                $sqlstr1 = $sqlstr." limit ".$f_pageNum.",".$pagesize;//定义SQL语句，通过limit关键字控制查询范围和
                $result = mysqli_query($conn,$sqlstr1);
                $sum=0;
                while ($rows = mysqli_fetch_row($result)){
                    echo "<tr><td height='25' align='center' class='m_td'>";
                    echo "<input type=checkbox name='chk[]' id='chk' value=".$rows[0].">";
                    echo "</td>";
                    echo "<td height='25' align='center' class='m_td'>".$rows[3]."</td>";
                    echo "<td height='25' align='center' class='m_td'>".$rows[6]."</td>";
                    echo "<td height='25' align='center' class='m_td'>".$rows[4]."</td>";
                    echo "<td height='25' align='center' class='m_td'>".$rows[5]."</td>";
                    echo "<td height='25' align='center' class='m_td'>".$rows[5]*$rows[6]."</td>";
                    $sum=$sum+$rows[5]*$rows[6];
                    echo "<td class='m_td'><a href=deletesgouwuche.php?action=del&id=".$rows[0]." onclick = 'return del();'>删除</a></td>";
                    echo "</tr>";
                }
                ?>
                    <tr>
                        <td height="25" colspan="2" class="m_td" align="left">
                            <a href="" onClick="return chek();">全部选择/取消</a>&nbsp;&nbsp;
                            <input type="hidden" name="action" value="delall"><input type="submit" value="删除选择" onclick = 'return del();'>&nbsp;&nbsp;</td>
                        <td>
                           <a href="updategouwuche.php">修改</a></td>
                        <td><a href="qingkonggouwuche.php">清空购物车</a></td>
                        <td align="right">总价：</td>
                        <td><a href="" id="price"><p class="zj">¥<?php echo "$sum"?></p></a></td>
                        <td class="jiesuan"><a href="">去结算</a></td>
                    </tr>
            </table>
            <?php
            echo "共".$totalNum."件商品&nbsp;&nbsp;";
            echo "第".$page."页/共".$pagecount."页&nbsp;&nbsp;";
            if($page!=1){//如果当前页不是1则输出有链接的首页和上一页
                echo "<a href='?page=1'>首页</a>&nbsp;";
                echo "<a href='?page=".($page-1)."'>上一页</a>&nbsp;&nbsp;";
            }else{//否则输出没有链接的首页和上一页
                echo "首页&nbsp;上一页&nbsp;&nbsp;";
            }
            if($page!=$pagecount){//如果当前页不是最后一页则输出有链接的下一页和尾页
                echo "<a href='?page=".($page+1)."'>下一页</a>&nbsp;";
                echo "<a href='?page=".$pagecount."'>尾页</a>&nbsp;&nbsp;";
            }else{//否则输出没有链接的下一页和尾页
                echo "下一页&nbsp;尾页&nbsp;&nbsp;";
            }
            ?>
        </form>
    </div>
</div>
<div class="bottom">
    <img src="images/gwc2.JPG" width="100%">
</div>
</body>
</html>