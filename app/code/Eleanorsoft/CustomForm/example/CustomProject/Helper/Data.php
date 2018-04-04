<?php

namespace Eleanorsoft\CustomProject\Helper;

use Eleanorsoft\CustomForm\Helper\Data as BaseData;
/**
 * Class Data
 *
 * @package Eleanorsoft\CustomProject\Helper
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Data extends BaseData
{
    protected $enabled = 'custom_project/general/enabled';
    protected $template = 'custom_project/email/email_template';
    protected $sender = 'custom_project/email/sender_email_identity';
    protected $recipient = 'custom_project/email/recipient_email';

    /**
     * Add file to email
     * @return mixed
     * @throws \Exception
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function getEmailAttachments()
    {
        $dataImg = array();
        $files = $this->getRequest()->getFiles()->get('photo');

        if (count($files) > 0){

            for($i = 0; $i < count($files); $i++){

                $file = $files[$i];

                if ($this->uploadedFileExists($file['size'])){

                    if ($this->validateUploadedFile($file)){

                        $imgName = basename($file['name']);
                        $imgContent = file_get_contents($file['tmp_name']);
                        $dataImg[$i][self::ATTACHMENT_FILE_NAME] = $imgName;
                        $dataImg[$i][self::ATTACHMENT_FILE_CONTENT] = $imgContent;
                    }
                }else {
                    throw new \Exception("Invalid file Type or file Size Exceeded",
                        self::HANDLE_ERROR_STATUS_CODE);
                }

            }
        }
        return $dataImg;
    }

    private function uploadedFileExists($size)
    {
        return (intval($size) > 0);
    }

    /**
     * validate uploaded file
     *
     * @param $i
     * @return bool
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    private function validateUploadedFile($file)
    {
        return (
            $this->validateMimeType($file['type'])
            && $this->validateSize($file['size'])
            && $this->validateExtension($file['name'])
        );
    }

    /**
     * valid file type
     *
     * @param $type
     * @return bool
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    private function validateMimeType($type)
    {
        $tmp = explode('/', $type);
        return ($tmp && $tmp[0] == 'image');
    }

    /**
     * valid file size
     *
     * @param $size
     * @return bool
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    private function validateSize($size)
    {
        return ($size <= 3 * 1024 * 1024);
    }

    /**
     * valid file extension
     *
     * @param $extension
     * @return bool
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    private function validateExtension($extension)
    {
        $validExtensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
        return in_array(pathinfo($extension, PATHINFO_EXTENSION), $validExtensions);
    }

}