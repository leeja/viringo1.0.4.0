<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para Subir archivos
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  14/03/2012
 * @access public
 */
class Class_UpFile
{

    /**
     * Maximo Tamaño para subir
     * @var integer
     * @access private
     */
    private $_maxFile;

    /**
     * Nombre del archivo
     * @var string
     * @access private
     */
    private $_name;

    /**
     * Nombre Temporal del archivo
     * @var string
     * @access private
     */
    private $_tmp;

    /**
     * Tamaño del archivo
     * @var integer
     * @access private
     */
    private $_size;

    /**
     * Tipo de archivo
     * @var string
     * @access private
     */
    private $_type;

    /**
     * @var string
     * @access private
     */
    private $_nameTemp;

    /**
     * Número de Bytes en un KB
     * @var integer
     */
    const KB = 1024;

    /**
     * Número de Bytes en un MB
     * @var integer
     */
    const MB = 1048576;

    /**
     * Archivos Adobe Acrobat
     * @var string
     */
    const TYPE_PDF = 'application/pdf';

    /**
     * Archivos de AutoCAD
     * @var string
     */
    const TYPE_DWG = 'application/acad';

    /**
     * Archivos de AutoCAD
     * @var string
     */
    const TYPE_DXF = 'application/dxf';

    /**
     * Archivos de ClarisCAD
     * @var string
     */
    const TYPE_CCAD = 'application/clariscad';

    /**
     * Archivos de bosquejo preliminar de MATRA
     * @var string
     */
    const TYPE_DRW = 'application/drafting';

    /**
     * Archivos tar comprimidos
     * @var string
     */
    const TYPE_TAR = 'application/x-tar';

    /**
     * Archivos ZIP comprimidos
     * @var string
     */
    const TYPE_ZIP = 'application/zip';

    /**
     * Archivos JavaScript js
     * @var string
     */
    const TYPE_JS = 'application/javascript';

    /**
     * Archivos MPEG4
     * @var string
     */
    const TYPE_MPEG4 = 'application/mp4';

    /**
     * Archivos de documentos Microsoft Word doc
     * @var string
     */
    const TYPE_DOC = 'application/msword';

    /**
     * Archivos de hojas de cálculo Microsoft Excel xls
     * @var string
     */
    const TYPE_XLS = 'application/vnd.ms-excel';

    /**
     * Archivos de presentación Microsoft Powerpoint ppt
     * @var string
     */
    const TYPE_PPT = 'application/vnd.ms-powerpoint';

    /**
     * Archivo XML xml
     * @var string
     */
    const TYPE_XML = 'application/xml';

    /**
     * binarios no interpretados
     * @var string
     */
    const TYPE_BIN = 'application/octet-stream';

    /**
     * Imágenes Gif
     * @var string
     */
    const TYPE_GIF = 'image/gif';

    /**
     * Imágenes jpeg jpg, jpeg,  jpe
     * @var string
     */
    const TYPE_JPG = 'image/jpeg';

    /**
     * Imágenes PNG
     * @var string
     */
    const TYPE_PNG = 'imagen/png';

    /**
     * Archivos Zip almacenados
     * @var string
     */
    const TYPE_XZIP = 'multipart/x-zip';

    /**
     * Archivos Zip GNU almacenados gz, gzip
     * @var string
     */
    const TYPE_GZIP = 'multipart/x-gzip';

    /**
     * Archivos HTML htm, html
     * @var string
     */
    const TYPE_HTML = 'text/html';

    /**
     * Archivos de texto sin formato txt, g, h, c, cc, hh, m, f90
     * @var string
     */
    const TYPE_TXT = 'text/plain';

    /**
     * Archivos de texto enriquecido rtx
     * @var string
     */
    const TYPE_RTX = 'text/richtext';

    /**
     * Hoja de estilo css
     * @var string
     */
    const TYPE_CSS = 'text/css';

    /**
     * Archivos de texto separados por comas csv
     * @var string
     */
    const TYPE_CSV = 'text/csv';

	/**
     * Video MPEG mpeg, mpg, mpe
     * @var string
     */
    const TYPE_MPEG = 'video/mpeg'; //  


    
    /**
     * Método Constructor, Asigna los valores del arreglo $_FILE a variables privadas.
     * 
     * @param array $file
     * @return void
     */
    public function __construct($file)
    {
        if (isset($file) and gettype($file) == 'array') {

            $this->_name = isset($file['name']) ? $file['name'] : null;
            $this->_tmp = isset($file['tmp_name']) ? $file['tmp_name'] : null;
            $this->_size = isset($file['size']) ? $file['size'] : null;
            ;
            $this->_type = isset($file['type']) ? $file['type'] : null;


        } else
            Class_Error::messageError('Not exist File');
    }

    
    /**
     * Retorna el tamaño del archivo.
     * 
     * @return integer
     */
    public function getSizeFile()
    {

        if (!empty($this->_size))
            return $this->_size;
        else
            return null;

    }
    
    /**
     * Retorna el nombre Temporal del archivo.
     * 
     * @return string
     */
    public function getTmpFile()
    {

        if (!empty($this->_tmp))
            return $this->_tmp;
        else
            return null;

    }

    /**
     * Retorna el tipo de archivo.
     * 
     * @return string
     */
    public function getTypeFile()
    {

        if (!empty($this->_type))
            return $this->_type;
        else
            return null;
    }

    
    /**
     * Retorna el nombre del archivo encriptado para grabar.
     * 
     * @param string $file
     * @return string
     */
    public function getNameFileToUp($file)
    {
        return sha1($file);
    }
    
    
    /**
     * Retorna el nombre del archivo.
     * 
     * @return string
     */
    public function getNameFile()
    {
        return $this->_name;
    }

    
    /**
     * verifica si el archivo es del tipo de archivo enviado por el parametro.
     * 
     * @param string $tempTypeFile
     * @return bool
     */
    public function isTypeFile($tempTypeFile)
    {
        echo $this->_type;
        if ($tempTypeFile == $this->_type)
            return true;
        else
            return false;
    }

    
    /**
     * Verica si el tamaño del archivo es menor, al tamaño configurado en PHP.ini.
     * 
     * @return bool
     */
    public function canUpFile()
    {

        $upload_max_filesize = ini_get('upload_max_filesize');
        $post_max_size = ini_get('post_max_size');
        $maxSize = ((int)$upload_max_filesize <= (int)$post_max_size) ? (int)$upload_max_filesize : (int)
            $post_max_size;
        $maxSize = $maxSize * self::MB;

        if ($maxSize >= $this->_size)
            return true;
        else
            return false;

    }
    
    
    /**
     * Retorna el tamaño maximo de un archivo para poder subir al servidor.
     * 
     * @return integer
     */
    public function getMaxSize()
    {

        $upload_max_filesize = ini_get('upload_max_filesize');
        $post_max_size = ini_get('post_max_size');
        $this->_maxFile = ((int)$upload_max_filesize <= (int)$post_max_size) ? $upload_max_filesize :
            $post_max_size;

        return $this->_maxFile;

    }
    
    
    /**
     * Verifica que el nombre del archivo no este vacio.
     * 
     * @return bool
     */
    public function isNameNotEmpty()
    {
        if (isset($this->_name))
            return true;
        else
            return false;
    }
    

    /**
     * Sube un archivo al servidor.
     * 
     * @param string $nameFile Nombre del archivo a subir
     * @param string $tempPath Ruta donde se subira el archivo
     * @return bool
     */
    public function upFile($nameFile, $tempPath = null)
    {
        
            if (!empty($tempPath))
                $path = $tempPath;
            else
                $path = Class_Config::get('pathUpFile');
            if (move_uploaded_file($this->_tmp, $path . $nameFile))
                return true;
            else
                Class_Error::messageError('Unable to upload the file');
        

    }


}


/*

application/atom+xml Archivos en formato ATOM atom 
application/iges Archivos CAS iges 
application/iges Formato de intercambio IGES CAD igs, iges 


application/postscript Archivos PostScript ai, eps, ps 
application/rtf Formato de texto enriquecido rtf 
application/sgml Archivos SGML  sgml 
application/x-tar Archivos TAR comprimidos tar 
application/zip Archivos ZIP comprimidos man 
audio/basic Archivos de audio básicos au, snd 
audio/mpeg Archivo de audio MPEG mpg,mp3 
audio/mp4 Archivo de audio MPEG-4 mp4 
audio/x-aiff Archivos de audio AIFF aif, aiff, aifc 
audio/x-wav Archivos de audio Wav wav 


image/tiff ?Imágenes Tiff tiff, tif 
image/x-portable-bitmap Archivos Bitmap PBM pbm 
image/x-portable-graymap Archivos Graymap PBM pgm 
image/x-portable-pixmap Archivos Pixmap PBM ppm 
multipart/x-zip Archivos comprimidos en Zip zip 
multipart/x-gzip Archivos comprimidos en Zip GNU gz, gzip 


text/rtf Archivos de texto con formato enriquecido rtf 
text/tab-separated-value Archivos de texto separados por tabulador tsv 
text/xml Archivos XML xml 
video/h264 Vídeos H.264  h264 
video/dv Vídeos DV dv 
video/mpeg Vídeos MPEG mpeg, mpg, mpe 
video/quicktime Vídeos QuickTime qt, mov 
video/msvideo Vídeos Microsoft Windows avi 

application/i-deas Archivos de SDRC I-deas unv 
application/iges Formato de intercambio CAO IGES igs, iges 
application/octet-stream Archivos binarios no interpretados bin 
application/oda Archivos ODA oda 
application/postscript Archivos PostScript ai, eps, ps 
application/pro_eng Archivos de ProEngineer prt 
application/rtf Formato de texto enriquecido rtf 
application/set Archivos CAO SET set 
application/sla Archivos de estereolitografía stl 
application/solids Archivos solids de MATRA dwg 
application/step Archivos de datos STEP step 
application/vda Archivos de superficie vda 
application/x-mif Archivos de Framemaker mif 
application/x-csh Secuencia de comandos C-Shell (UNIX) dwg 
application/x-dvi Archivos de texto dvi dvi 
application/hdf Archivos de datos hdf 
application/x-latex Archivos de LaTEX latex 
application/x-netcdf Archivos de NetCDF nc, cdf 
application/x-sh Secuencia de comandos Bourne Shell dwg 
application/x-tcl Secuencia de comandos Tcl tcl 
application/x-tex Archivos tex tex 
application/x-texinfo Archivos eMacs texinfo, texi 
application/x-troff Archivos Troff t, tr, troff 
application/x-troff-man Archivos Troff/macro man man 
application/x-troff-me Archivos Troff/macro ME me 
application/x-troff-ms Archivos Troff/macro MS ms 
application/x-wais-source Fuente Wais src 
application/x-bcpio CPIO binario bcpio 
application/x-cpio CPIO Posix cpio 
application/x-gtar Tar GNU gtar 
application/x-shar Archivos Shell shar 
application/x-sv4cpio CPIO SVR4n sv4cpio 
application/x-sv4crc CPIO SVR4n con CRC sc4crc 

application/x-ustar Archivos tar Posix comprimidos man 

audio/basic Archivos de audio básicos au, snd 
audio/x-aiff Archivos de audio AIFF aif, aiff, aifc 
audio/x-wav Archivos de audio Wave wav 
image/ief Imágenes con formato de intercambio ief 
image/tiff Imágenes tiff tiff, tif 
image/x-cmu-raster Ráster cmu cmu 
image/x-portable-anymap Archivos Anymap PBM pnm 
image/x-portable-bitmap Archivos de mapa de bits PBM pbm 
image/x-portable-graymap Archivos Graymap PBM pgm 
image/x-portable-pixmap Archivos Pixmap PBM ppm 
image/x-rgb Imágenes RGB rgb 
image/x-xbitmap Imágenes X Bitmap xbm 
image/x-xpixmap Imágenes X Pixmap xpm 
image/x-xwindowdump Imágenes de volcado X Window man 


text/tab-separated-value Archivos de texto con separación de valores tsv 
text/x-setext Archivos de texto struct etx 

video/quicktime Videos de QuickTime qt, mov 
video/msvideo Videos de Microsoft Windows avi 
video/x-sgi-movie Videos de MoviePlayer movie 
*/
