<?php





exit;


$str = "http://dev-account.dodoedu.com/userRecovery/recoverMailValid?s=i6OAv8vbZvUbGyMQNXzORBDa8%2BF9usUkHxyPzVeZuD6x2YzJOBwGY%2Fky1lXg3QocG0%2B1KSND35lVF1LwfG1tNg%3D%3D";
echo $str.'<br>';
echo rawurlencode($str).'<br>';
echo rawurlencode(rawurlencode($str)).'<br>';
