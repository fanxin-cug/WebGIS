<?php
/**
 * Created by PhpStorm.
 * User: fanxin
 * Date: 18-5-15
 * Time: 下午4:47
 */
session_start();
session_destroy();
echo "<script>window.location.href='index.html';</script>";