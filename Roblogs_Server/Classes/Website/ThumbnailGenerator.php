<?php

class ThumbnailGenerator{
        
    protected $IMG_link;
    protected $Transparent = false;
    protected $Height = 100;
    protected $Width = 100;

    public function Height($Height){$this->Height = $Height;}

    public function Width($Width){$this->Width = $Width;}

    public function IMG_Link($Link){$this->IMG_link = $Link;}

    public function Transparent(){$this->Transparent = true;}

    public function Generate()
    {
        if(file_exists($this->IMG_link) == false)
        {
            throw new Exception("Invalid Image");
        }

        $ThumbnailBase = imagecreatetruecolor($this->Width,$this->Height);
        $IMG_Data = getimagesize($this->IMG_link);

        switch($IMG_Data["mime"])
        {
            case "image/png":
                $trans_colour = imagecolorallocatealpha($ThumbnailBase, 0, 0, 0, 127);
                imagefill($ThumbnailBase, 0, 0, $trans_colour);
                imagesavealpha($ThumbnailBase,true);

                $ImageCreate = @imagecreatefrompng($this->IMG_link);
                imagesavealpha($ImageCreate, true);
            break;

            case "image/jpeg":
                $ImageCreate = @imagecreatefromjpeg($this->IMG_link);    
            break;
        }

        $GetSize = getimagesize($this->IMG_link);

        $Background = $this->Transparent != true ? imagecolorallocate($ThumbnailBase, 255, 255, 255) : imagecolorallocatealpha($ThumbnailBase, 0, 0, 0, 127);

        imagefill($ThumbnailBase,0,0,$Background);
        list($ancho, $alto) = $GetSize;

        imagecopyresized($ThumbnailBase,$ImageCreate,0,0,0,0,$this->Width,$this->Height,$ancho,$alto);
        imagepng($ThumbnailBase);
        imagedestroy($ThumbnailBase);
    }

    static function DrawMissingThumbnail($URL)
    {
        $ImageCreate = @imagecreatefrompng($URL);
        imagepng($ImageCreate);



    }
    
}

?>