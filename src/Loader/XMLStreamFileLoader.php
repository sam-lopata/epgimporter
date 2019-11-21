<?php

namespace EPGImporter\Loader;

use DOMNode;

/**
 * Wrapper on XMLReader which provides more convenient and safe way of parsing xml documents and streams
 *
 * Class XMLStreamFileLoader
 *
 * Provides means for reading XML-formatted document or stream line by line
 *
 * @package EPGImporter\Loader
 */
class XMLStreamFileLoader extends \XMLReader implements StreamLoaderInterface
{
    /** @var string */
    private $source;

    /** @var \DomNode|mixed Last operation result */
    private $lastStatus;

    /**
     * @param string $source Name of the file with XML located
     *
     * @throws LoaderException
     * @return XMLStreamFileLoader
     */
    public function init(string $source) : self
    {
        $this->source = ltrim($source);

        if ($this->isXmlDocument($this->source))
        {
            $this->XML($this->source, null, LIBXML_NOBLANKS | LIBXML_DTDLOAD);
        }
        else
        {
            $success = @$this->open($this->source, null, LIBXML_NOBLANKS | LIBXML_DTDLOAD);

            if (!$success)
            {
                throw new LoaderException(sprintf('File "%s" doesn\'t exist or is unreadable', $this->source));
            }
        }
        $this->setParserProperty(\XMLReader::SUBST_ENTITIES, true);

        while ($this->nodeType !== \XMLReader::ELEMENT)
        {
            $this->readLine();
        }

        return $this;
    }

    /**
     * @throws LoaderException
     * @return XMLStreamFileLoader
     */
    public function readLine() : self
    {
        libxml_clear_errors();

        $this->lastStatus = @parent::read();
        $error = libxml_get_last_error();
        if ($error)
        {
            libxml_clear_errors();
            throw new LoaderException(sprintf('Xml read error "%s" in file "%s" on line %s on column %s', $error->message, $error->file, $error->line, $error->column));
        }

        return $this;
    }

    /**
     * @param DOMNode $basenode
     *
     * @throws LoaderException
     * @return XMLStreamFileLoader
     */
    public function expandNode() : self
    {
        libxml_clear_errors();

        $this->lastStatus = @parent::expand();
        $error = libxml_get_last_error();
        if ($error)
        {
            libxml_clear_errors();
            throw new LoaderException(sprintf('Xml expand error "%s" in file "%s" on line %s on column %s', $error->message, $error->file, $error->line, $error->column));
        }

        return $this;
    }

    /**
     * @return \DomNode|mixed
     */
    public function getLastOperationStatus()
    {
        return $this->lastStatus;
    }

    /**
     * @param $content
     *
     * @return bool
     */
    protected function isXmlDocument(string $content) : bool
    {
        return strpos($content, '<') === 0;
    }
}
