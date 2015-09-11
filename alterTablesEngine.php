<?php

$aRs = array(
    'sch_group','sch_log','sch_module','sch_purview','sch_user'
);

foreach ($aRs as $v) {
    $currBakTable = $v."_b_141226";
    echo "create table {$currBakTable} select * from {$v};<br>";
    echo "alter table " . $v . " engine=InnoDB;<br>";
}
?>