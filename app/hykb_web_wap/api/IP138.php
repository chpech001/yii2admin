<?php
class IP138
{
    private static $fp     = NULL;
    private static $offset = NULL;

    public static function find($ip)
    {
        $long_ip = sprintf("%u",ip2long($ip));
        // 只支持32位二进制格式的ip并且非0.0.0.0和255.255.255.X的ip
        if (!$long_ip || ($long_ip >> 32) || ($long_ip>>8) == 0xffffff) {
            return 'N/A';
        }
        self::init();
        $range = self::getRange($long_ip);
        if (!$range) {
            self::close();
            return 'N/A';
        }
        $left = $range['left'];
        $right = $range['right'];
        while ($left < $right) {
            $mid = ($left + $right ) >> 1;
            fseek(self::$fp, $mid * 9 + 1024 + 4);
            $end_ip = current(unpack('I', fread(self::$fp, 4)));
            if ($end_ip < 0) {
                $end_ip = $end_ip + 1 + 0xffffffff;
            }
            if ($end_ip >= $long_ip) {
                $right = $mid;
            } else {
                $left = $mid + 1;
            }
        }
        $cur_offset = $left * 9 + 1024 + 4;
        if ($cur_offset >= self::$offset['len']) {
            self::close();
            return 'N/A';
        }
        fseek(self::$fp, $cur_offset);
        $end_ip = current(unpack('I', fread(self::$fp, 4)));
        if ($end_ip < 0) {
            $end_ip = $end_ip + 1 + 0xffffffff;
        }
        // 不在区间范围内，或者IP段不一致
        if ($end_ip < $long_ip || ($end_ip >> 24) != ($long_ip >> 24)) {
            self::close();
            return 'N/A';
        }
        $data_offset = current(unpack('I', fread(self::$fp, 4)));
        $data_length = current(unpack('C', fread(self::$fp, 1)));
        fseek(self::$fp, self::$offset['len'] + $data_offset);
        $info = explode("\t", fread(self::$fp, $data_length));
        self::close();
        return $info;
    }

    /**
     * 获取查找的左右区间
     * @param $long_ip
     * @return array|false
     */
    private static function getRange($long_ip)
    {
        $first_num = $long_ip >> 24;
        fseek(self::$fp, 4 + $first_num * 4);
        $left = current(unpack('I', fread(self::$fp, 4)));
        if ($first_num && !$left) {
            return false;
        }
        $right = 0;
        if ($first_num != 255) {
            $right = current(unpack('I', fread(self::$fp, 4)));
        }
        if ($right == 0) {
            $right = ceil((self::$offset['len'] - 4 - 1024) / 9);
        }
        return array('left' => $left, 'right' => $right);
    }

    private static function init()
    {
        if (self::$fp === NULL) {
		    $mydir=dirname(__FILE__);
            self::$fp = fopen($mydir . '/ip138.dat', 'rb');
            if (self::$fp === FALSE) {
                throw new Exception('Invalid ip.dat file!');
            }
            self::$offset = unpack('Ilen', fread(self::$fp, 4));
            if (self::$offset['len'] < 4) {
                throw new Exception('Invalid ip.dat file!');
            }
        }
    }

    private static function close()
    {
        if (self::$fp !== NULL) {
            fclose(self::$fp);
            self::$fp = NULL;
        }
    }
}