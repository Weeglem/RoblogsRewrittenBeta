<?php

class ImageUploader{

    protected $FinalLocation = "./";
    protected $OriginalImage;

    protected $Max_Width = 1920;
    protected $Max_Height = 1080;
    protected $Transparency = false;
    protected $UploadFile = false;

    public function Max_Width(Int $Max_Width = 1920){$this->Max_Width = $Max_Width;}
    public function Max_Heigth(Int $Max_Height = 1080){$this->Max_Height = $Max_Height;}
    public function Transparent(bool $Bool = false){$this->Transparency = $Bool;}
    public function SetFinalLocation(string $Directory = "./"){$this->FinalLocation = $Directory;}
    public function SetImageSource(string $ImageLocation = "./exampleImage.png"){$this->OriginalImage = $ImageLocation;}
    
    /** ImageUploader Process, Renders the image where UploadFile is set with true, else returns false */
    public function Execute()
    {

        if($this->OriginalImage == null){throw new Exception("Invalid Source Location");}
        if($this->FinalLocation == null){throw new Exception("Invalid Location");}
      
        //SAVE IMAGECREATE DATA IN IMAGECREATE VAR
        switch(mime_content_type($this->OriginalImage))
        {
            case "image/png":
                $ImageCreate = imagecreatefrompng($this->OriginalImage);
            break;
            case "image/jpeg":
                $ImageCreate = imagecreatefromjpeg($this->OriginalImage);
            break; 
            case "image/gif":
                $ImageCreate = imagecreatefromjpeg($this->OriginalImage);
            break; 
            default:
                throw new Exception("The Uploaded image format is Not Allowed");
            break;
        }

        //SAVE ITS TRANSPARENCY NO MATTER WHAT
        imagesavealpha($ImageCreate,true);

        //GET ORIGINAL WIDTHS AND HEIGHTS
        list($og_Width, $og_Height) = getimagesize($this->OriginalImage);

        //CREATE CANVAS
        $FinalWidth = $og_Width > $this->Max_Width ? $this->Max_Width : $og_Width;
        $FinalHeight = $og_Height > $this->Max_Height ? $this->Max_Height : $og_Height;

        $Canvas = imagecreatetruecolor($FinalWidth,$FinalHeight);

        //DRAW TRANSPARENT BACKGROUND
        if($this->Transparency == true){
            imagesavealpha($ImageCreate,true);
            $Background_Color = imagecolorallocatealpha($Canvas, 0, 0, 0,127); //inv backgrond
        }else{
            $Background_Color = imagecolorallocatealpha($Canvas, 255, 255, 255,0); //White BG
        }

        //PAINT THE CANVAS WITH TRANSPARENCY
        imagefill($Canvas, 0, 0, $Background_Color);
        imagesavealpha($Canvas,true);
        imagecopyresized($Canvas,$ImageCreate,0,0,0,0,$FinalWidth,$FinalHeight,$og_Width,$og_Height);

        //FINALIZE
        imagepng($Canvas,"$this->FinalLocation");
        return true;
    }

}