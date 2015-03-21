<?php  namespace Zbw\Training;


interface TrainingReportInterface {
    /**
     * @return integer
     */
    function getSessionId();

    /**
     * @return array
     */
    function getMarkups();

    /**
     * @return array
     */
    function getMarkdowns();

    /**
     * @return array
     */
    function getPerformance();

    /**
     * @return array
     */
    function getReviewed();

    /**
     * @return integer
     */
    function getPositivePoints();

    /**
     * @return integer
     */
    function getNegativePoints();

    /**
     * @return float
     */
    function getModifier();
} 
