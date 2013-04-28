<?php
namespace Goop\Form;
class File
{
	private $_uploaddir;
	private $_file;
	private $_files = array();
	private $_svfile;
	private $_svfiles = array();
    private $_ext;
	
	public function __construct($file)
	{
		$this->_file = $file;
		$this->_svfile = $file['name'];
        $this->_ext = $this->setExt($file['name']);
	}
	
	public function upload()
	{
		return move_uploaded_file($this->_file['tmp_name'], $this->getUploaddir().$this->_svfile);
	}
	
	public function getUploaddir() {
		return substr($this->_uploaddir, 0, -1) == '/'?$this->_uploaddir:$this->_uploaddir.DIRECTORY_SEPARATOR;
	}

	public function setUploaddir($_uploaddir) {
		$this->_uploaddir = $_uploaddir;
	}
	public function getSvfile() {
		return $this->_svfile;
	}

	public function setSvfile($_svfile) {
		$this->_svfile = $_svfile;
	}
    
    public function setExt($file_name)  
    {  
        $extend = explode("." , $file_name);
        if (count($extend) > 1){
        	$va = count($extend)-1;
        	return $extend[$va];
        } else { 
        	return null;
        }  
    }
    
    public function getExt()
    {
        return $this->_ext;
    }
}