<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <table border="1px" width="800px" >
        <tr>
            <th>用户名</th>
            <th>手机号</th>
            <th>邮箱</th>
            <th>所属公司</th>
        </tr>

            <?php foreach ($data as $k=>$v){
                $str = "";
                $str .="<tr><td>".$v['username']."</td>";
                $str .="<td>".$v['id']."</td>";
                $str .="<td>".$v['username']."</td>";
                $str .="<td>".$v['username']."</td></tr>";
                echo $str;
            }?>
    </table>
</div>
