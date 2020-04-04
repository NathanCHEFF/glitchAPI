<?php
/*
EN
This class will help you hide important monitoring and administration files.
It works like this: create a copy of the class and in it create the session $ x-> makeSession ('cpanel.htm').
The script will create a directory with a random name and size length and put a copy of your file there. 
With a new session, the directory with your file is cleared.

RU
Этот класс поможет вам сокрыть важные файлы контроля и администрирования.
Работает это так : создаем копию класса и в ней создаем сессию $x->makeSession('cpanel.htm') .
Скрипт создаст директорию с рандомным названием и длиной размера  и поместит туда копию вашего файла .
При новой сессии директория с вашим файлом очищаются.
*/
/**
 * hidenFile
 * 
 * @package 
 * @author NathanCHEEF
 * @copyright 2018/21/09
 * @version 0.1 beta
 * @access public
 */
class hidenFile
{
    var $file = ''; // файл который прячем
    var $data = '';

    /**
     * hidenFile::__construct()
     * 
     * @param mixed $file
     * @return void
     */
    public function __construct($file,$data = 'data.dat')
    {
        $this->file = $file;
        $this->data = $data;
        $this->makeSession();
    }

    /**
     * hidenFile::_get_file()
     * 
     * @return string name of file
     */
    public function _get_file()
    {
        return $file;
    }

    /**
     * hidenFile::_randName()
     * 
     * @param integer $count
     * @return string random
     */
    public function _randName($count = 8)
    {
        return substr(str_shuffle(MD5(microtime())), 0, $count);
    }

    /**
     * hidenFile::_sv__data()
     * 
     * @param mixed $data
     * @return bool
     */
    private function _sv__data( $data )
    {
// return (file_exists($this->data)) false : file_get_contents($this->data, $data);
        if ( file_exists( $this->data ) )
        {
            return false;
        } 
            else
        {
            return file_put_contents( $this->data , $data);
        }
    }

    /**
     * hidenFile::_clr__data()
     * 
     * @return
     */
    private function _clr__data()
    {                                                               #Returns TRUE on success or FALSE on failure.
        return unlink($this->data);
    }

    /**
     * hidenFile::_get__data()
     * 
     * @return
     */
    private function _get__data()
    {
        return file_get_contents($this->data);
    }

    /**
     * hidenFile::_set_file()
     * 
     * @param mixed $file
     * @return
     */
    function _set_file($file)
    {
        $this->file = $file;
    }

    /**
     * hidenFile::_get__extns()
     * 
     * @return string extenshion of file
     */
    private function _get__extns()
    {
        //return end(explode(".", $this->file));
        return substr(strrchr($this->file, '.'), 1);
    }

    /**
     * hidenFile::makeSession()
     * 
     * @return @string way to file
     */
    function makeSession()
    {
        if (file_exists($this->data))                                   #   if session already had opened
        {
            unlink($this->_get__data());
            rmdir($this->_get__dir());
            unlink($this->data);                                        #   clean him
        }
        
        $DIR = $this->_randName();
        $NAME = $this->_randName(rand(7, 15));
        mkdir($DIR);
        $NAME = $DIR . '/' . $NAME . '.' . $this->_get__extns();        #   create way and puting data
        file_put_contents($NAME, file_get_contents($this->file));       
        $this->_sv__data($NAME);
        return $NAME;
    }

    /**
     * hidenFile::unsetSession()
     * 
     * @return
     */
    function unsetSession()
    {
        unlink($this->_get__data());
        rmdir($this->_get__dir());
    }

    /**
     * hidenFile::_get__dir()
     * 
     * @return
     */
    private function _get__dir()
    {
        $way = $this->_get__data();
        return explode('/', $way)[0];
    }
    
    /**
     * hidenFile::_get__cookies()
     * 
     * @return
     */
    public function _get__cookies(){
        $way = $this->_get__data();
        $ret =  explode('/', $way);
        return array($ret[1] => $ret[0]);
    }
}

?>
