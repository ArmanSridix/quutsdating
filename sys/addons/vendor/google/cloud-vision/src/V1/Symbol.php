<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/vision/v1/text_annotation.proto

namespace Google\Cloud\Vision\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A single symbol representation.
 *
 * Generated from protobuf message <code>google.cloud.vision.v1.Symbol</code>
 */
class Symbol extends \Google\Protobuf\Internal\Message
{
    /**
     * Additional information detected for the symbol.
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.TextAnnotation.TextProperty property = 1;</code>
     */
    private $property = null;
    /**
     * The bounding box for the symbol.
     * The vertices are in the order of top-left, top-right, bottom-right,
     * bottom-left. When a rotation of the bounding box is detected the rotation
     * is represented as around the top-left corner as defined when the text is
     * read in the 'natural' orientation.
     * For example:
     *   * when the text is horizontal it might look like:
     *      0----1
     *      |    |
     *      3----2
     *   * when it's rotated 180 degrees around the top-left corner it becomes:
     *      2----3
     *      |    |
     *      1----0
     *   and the vertex order will still be (0, 1, 2, 3).
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.BoundingPoly bounding_box = 2;</code>
     */
    private $bounding_box = null;
    /**
     * The actual UTF-8 representation of the symbol.
     *
     * Generated from protobuf field <code>string text = 3;</code>
     */
    private $text = '';
    /**
     * Confidence of the OCR results for the symbol. Range [0, 1].
     *
     * Generated from protobuf field <code>float confidence = 4;</code>
     */
    private $confidence = 0.0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Vision\V1\TextAnnotation\TextProperty $property
     *           Additional information detected for the symbol.
     *     @type \Google\Cloud\Vision\V1\BoundingPoly $bounding_box
     *           The bounding box for the symbol.
     *           The vertices are in the order of top-left, top-right, bottom-right,
     *           bottom-left. When a rotation of the bounding box is detected the rotation
     *           is represented as around the top-left corner as defined when the text is
     *           read in the 'natural' orientation.
     *           For example:
     *             * when the text is horizontal it might look like:
     *                0----1
     *                |    |
     *                3----2
     *             * when it's rotated 180 degrees around the top-left corner it becomes:
     *                2----3
     *                |    |
     *                1----0
     *             and the vertex order will still be (0, 1, 2, 3).
     *     @type string $text
     *           The actual UTF-8 representation of the symbol.
     *     @type float $confidence
     *           Confidence of the OCR results for the symbol. Range [0, 1].
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Vision\V1\TextAnnotation::initOnce();
        parent::__construct($data);
    }

    /**
     * Additional information detected for the symbol.
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.TextAnnotation.TextProperty property = 1;</code>
     * @return \Google\Cloud\Vision\V1\TextAnnotation\TextProperty|null
     */
    public function getProperty()
    {
        return $this->property;
    }

    public function hasProperty()
    {
        return isset($this->property);
    }

    public function clearProperty()
    {
        unset($this->property);
    }

    /**
     * Additional information detected for the symbol.
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.TextAnnotation.TextProperty property = 1;</code>
     * @param \Google\Cloud\Vision\V1\TextAnnotation\TextProperty $var
     * @return $this
     */
    public function setProperty($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Vision\V1\TextAnnotation\TextProperty::class);
        $this->property = $var;

        return $this;
    }

    /**
     * The bounding box for the symbol.
     * The vertices are in the order of top-left, top-right, bottom-right,
     * bottom-left. When a rotation of the bounding box is detected the rotation
     * is represented as around the top-left corner as defined when the text is
     * read in the 'natural' orientation.
     * For example:
     *   * when the text is horizontal it might look like:
     *      0----1
     *      |    |
     *      3----2
     *   * when it's rotated 180 degrees around the top-left corner it becomes:
     *      2----3
     *      |    |
     *      1----0
     *   and the vertex order will still be (0, 1, 2, 3).
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.BoundingPoly bounding_box = 2;</code>
     * @return \Google\Cloud\Vision\V1\BoundingPoly|null
     */
    public function getBoundingBox()
    {
        return $this->bounding_box;
    }

    public function hasBoundingBox()
    {
        return isset($this->bounding_box);
    }

    public function clearBoundingBox()
    {
        unset($this->bounding_box);
    }

    /**
     * The bounding box for the symbol.
     * The vertices are in the order of top-left, top-right, bottom-right,
     * bottom-left. When a rotation of the bounding box is detected the rotation
     * is represented as around the top-left corner as defined when the text is
     * read in the 'natural' orientation.
     * For example:
     *   * when the text is horizontal it might look like:
     *      0----1
     *      |    |
     *      3----2
     *   * when it's rotated 180 degrees around the top-left corner it becomes:
     *      2----3
     *      |    |
     *      1----0
     *   and the vertex order will still be (0, 1, 2, 3).
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.BoundingPoly bounding_box = 2;</code>
     * @param \Google\Cloud\Vision\V1\BoundingPoly $var
     * @return $this
     */
    public function setBoundingBox($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Vision\V1\BoundingPoly::class);
        $this->bounding_box = $var;

        return $this;
    }

    /**
     * The actual UTF-8 representation of the symbol.
     *
     * Generated from protobuf field <code>string text = 3;</code>
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * The actual UTF-8 representation of the symbol.
     *
     * Generated from protobuf field <code>string text = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setText($var)
    {
        GPBUtil::checkString($var, True);
        $this->text = $var;

        return $this;
    }

    /**
     * Confidence of the OCR results for the symbol. Range [0, 1].
     *
     * Generated from protobuf field <code>float confidence = 4;</code>
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Confidence of the OCR results for the symbol. Range [0, 1].
     *
     * Generated from protobuf field <code>float confidence = 4;</code>
     * @param float $var
     * @return $this
     */
    public function setConfidence($var)
    {
        GPBUtil::checkFloat($var);
        $this->confidence = $var;

        return $this;
    }

}

