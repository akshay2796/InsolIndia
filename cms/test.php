<?php
$Ftime=strtotime('16:30:00');
echo $Ftime;
echo "<br><br>";
                    $hourd = date("H",$Ftime);
                    $mind = date("i",$Ftime);
                    $secd = date("s",$Ftime);
                    $am_pm = date("A",$Ftime);
                    echo $hourd;
                    echo $mind;
                    echo $secd;
$timestamp = date("d/m/Y H:i:s", time());
// echo $timestamp;
// 1594033200