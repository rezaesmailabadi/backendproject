<?php

namespace App\Http\Services\Image;

class ImageToolsService
{

    protected $image;
    protected $exclusiveDirectory;
    protected $imageDirectory;
    protected $imageName;
    protected $imageFormat;
    protected $finalImageDirectory;
    protected $finalImageName;




    public function setImage($image)
    {
        
        $this->image = $image;
    }

    // چرا پابلیک فانکشن گت آن ننوشته شده است ؟؟؟؟





    // -----------------------------------------------------------------------------------
    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }

    // دایرکتوری منحصر به فرد     /image/post-category/

    public function setExclusiveDirectory($exclusiveDirectory)
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }





    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    // 2021/10/1

    public function setImageDirectory($imageDirectory)
    {
        $this->imageDirectory = trim($imageDirectory, '/\\');
    }

    // ------------------------------------------------------------------------------






    public function getImageName()
    {
        return $this->imageName;
    }

        // اسم خود عکس 

     public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }






    public function setCurrentImageName()
    {
            return !empty($this->image) ? $this->setImageName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME)) : false;
            // $_FILES['image']['name']
            // getClientOriginalName => نام اصلی اون فایلی که ارسال شده دسترسی خواهیم داشت.
    }






    public function getImageFormat()
    {
        return $this->imageFormat;
    }

   public function setImageFormat($imageFormat)
    {
        $this->imageFormat = $imageFormat;
    }








    public function getFinalImageDirectory()
    {
        return $this->finalImageDirectory;
    }

// image/postcategory/2021/10/1 
    
public function setFinalImageDirectory($finalImageDirectory)
    {
        $this->finalImageDirectory = $finalImageDirectory;
    }




   public function getFinalImageName()
    {
        return $this->finalImageName;
        // get => خروجی رو میده بیرون
    }
            // reza.png 
    public function setFinalImageName($finalImageName)
    {
        // set => روش عملیات انجام میده 
        $this->finalImageName = $finalImageName;
    }






    protected function checkDirectory($imageDirectory)
    {
        if(!file_exists($imageDirectory))
        {
            mkdir($imageDirectory, 0755, true);
        }
    }



    public function getImageAddress()
    {
        return $this->finalImageDirectory . DIRECTORY_SEPARATOR . $this->finalImageName;
    }



    protected function provider()
    {
      
        //set properties
        $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
        $this->getImageName() ?? $this->setImageName(time());
        $this->getImageFormat() ?? $this->setImageFormat($this->image->extension());



        
        //set final image Directory
        $finalImageDirectory = empty($this->getExclusiveDirectory()) ? $this->getImageDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getImageDirectory();
        $this->setFinalImageDirectory($finalImageDirectory);


        //set final image name
        $this->setFinalImageName($this->getImageName() . '.' . $this->getImageFormat());


        //check adn create final image directory
        $this->checkDirectory($this->getFinalImageDirectory());
        
    }










}
