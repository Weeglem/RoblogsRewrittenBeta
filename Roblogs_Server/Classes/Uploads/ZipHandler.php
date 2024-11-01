<?php

class ZipHandler{

    protected $Allowed_Types = array("rbxl","rbxm");
    protected $InvalidFiles = 0;
    protected $ExpectedFiles = 0;
    protected $ZipFile = "./test.zip";
    protected $TempFolder = "./Temp/";
    protected $Limit_files = 1;

    public function SetZipSource(String $Dir = "./test.zip"){$this->ZipFile = $Dir;}
    public function SetTempFolder(String $Dir = "./temp/"){$this->TempFolder = $Dir;}
    public function SetAllowedTypes(Array $Array = array("rbxl","rbxm")){$this->Allowed_Types = $Array;}

    /**Returns ROBLOX RBXL Extracted location, else returns null */
    public function Analyze_Roblox_ZIPHandler()
    {

        $ReturnLine = null;
        if($this->Validate_Zip($this->ZipFile) == false){throw new Exception("Upload a Valid .ZIP or .RAR File");};
        $ZipArchive = new ZipArchive();
        if($ZipArchive->open($this->ZipFile) == false){throw new Exception("Invalid ZIP file");}
        if($ZipArchive->numFiles == 0){throw new Exception("The provided ZIP is empty");}
        
        //FOR EACH FILE IN THE ZIP
        for($i=0;$i < $ZipArchive->numFiles; $i++){

            if($this->ExpectedFiles == 0){  //KILL FOR IF ALREADY GOT A FILE

                $ActualFile = $ZipArchive->getNameIndex($i);

                //ANALYZE FILE FORMAT, EXIT IF INVALID
                if(!in_array(strtolower(pathinfo($ActualFile, PATHINFO_EXTENSION)),$this->Allowed_Types)){throw new Exception("Invalid file found,");}
                $this->ExpectedFiles++;

                $TempName = Website::RandomString();
                $ZipArchive->renameName($ActualFile,$TempName);
                $ZipArchive->extractTo($this->TempFolder,array($TempName));

                //RETURN LINK AND KILL THIS FOR LOOP
                $ReturnLine = $this->TempFolder."/".$TempName;
                $this->ExpectedFiles++;
            }
        }
        
        $ZipArchive->close();
        unlink($this->ZipFile);
        return $ReturnLine;

    }

    public function Analyze_Normal()
    {
        echo "Running Normal Exploration..<br>";
        $ZipArchive = new ZipArchive();
        if($ZipArchive->open($this->ZipFile) == false){throw new Exception("Invalid ZIP file");}
        if($ZipArchive->numFiles == 0){throw new Exception("The provided ZIP is empty");}

        //FOR EACH FILE IN THE ZIP
        for($i=0;$i < $ZipArchive->numFiles; $i++){
            $ActualFile = $ZipArchive->getNameIndex($i);

            //ANALYZE FILE FORMAT, EXIT IF INVALID
            if(!in_array(strtolower(pathinfo($ActualFile, PATHINFO_EXTENSION)),$this->Allowed_Types)){throw new Exception("Invalid file found,");}
            $this->ExpectedFiles++;
        }
        return;
    }

    protected function Validate_Zip($Zip)
    {
        if(empty($Zip)){
            return false;
        }

        $fh = @fopen($Zip, "r");

        if (!$fh) {
        print "ERROR: couldn't open file.\n";
        return false;
        }

        $blob = fgets($fh, 5);

        fclose($fh);

        if (strpos($blob, 'Rar') !== false) {
        return true;
        } else
        if (strpos($blob, 'PK') !== false) {
        return true;
        } else {
        return false;
        }

        return false;
    }
}