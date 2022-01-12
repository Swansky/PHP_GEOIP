<?php


class ParametersManager
{
    private Parameter $parameter;
    private const SHORT_OPTIONS = "p:s:e:m:d:h";
    private const LONG_OPTIONS = array("path:", "separator:", "help", "end:", "method:", "database:");

    public function checkOptions()
    {
        $this->parameter = new Parameter();
        $options = getopt(self::SHORT_OPTIONS, self::LONG_OPTIONS);
        if (isset($options["h"]) || isset($options["help"])) {
            $this->printHelp();
        }
        if (isset($options["p"])) {
            $this->parameter->setCsvPath($options["p"]);
        }
        if (isset($options["path"])) {
            $this->parameter->setCsvPath($options["path"]);
        }
        if (isset($options["s"])) {
            $this->parameter->setSeparator($options["s"]);
        }
        if (isset($options["separator"])) {
            $this->parameter->setSeparator($options["separator"]);
        }
        if (isset($options["e"])) {
            $this->parameter->setEndCsvLineString($options["e"]);
        }
        if (isset($options["end"])) {
            $this->parameter->setEndCsvLineString($options["end"]);
        }
        if (isset($options["m"])) {
            $this->parameter->setMethodUsed(intval($options["m"]));
        }
        if (isset($options["method"])) {
            $this->parameter->setMethodUsed(intval($options["method"]));
        }
        if (isset($options["d"])) {
            $this->parameter->loadDatabaseConfigFile($options["d"]);
        }
        if (isset($options["database"])) {
            $this->parameter->loadDatabaseConfigFile($options["database"]);
        }

        $this->parameter->checkParameters();
    }

    function printHelp(): void
    {
        $classic = Parameter::$CLASSIC_METHOD;
        $fast = Parameter::$FAST_METHOD;
        echo "-------------------------------------------------------\n";
        echo "           script migration parameters\n";
        echo "  -p  | --path      <path>      (required) | indicate path of your csv file \n";
        echo "  -s  | --separator <separator> (optional) | separator used in your csv file. default value: ',' \n";
        echo "  -h  | --help                             | show this text.\n";
        echo "  -e  | --end <end character>              | specify a character that defines the end of the csv line. Default: '\\n'. Only for method " . $fast . "\n";
        echo "  -d  | --database  <path>      (optional) | add path of json for database configuration \n";
        echo "  -m  | --method <" . $classic . ":" . $fast . ">                     | specify the method used to make the migration. " . $classic . "= classic technique consisting in parsing line by line. " . $fast . "= send the CSV file to the sql server.\n";
        echo "\n";
        echo "-------------------------------------------------------\n";
        exit();
    }

    /**
     * @return Parameter
     */
    public function getParameter(): Parameter
    {
        return $this->parameter;
    }


}