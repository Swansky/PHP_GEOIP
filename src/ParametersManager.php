<?php

class ParametersManager
{
    private Parameter $parameter;
    private const SHORT_OPTIONS = "p:s:h";
    private const LONG_OPTIONS = array("path:", "separator", "help");

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
        $this->parameter->checkParameters();
    }

    function printHelp(): void
    {
        echo "-------------------------------------------------------\n";
        echo "           script migration parameters\n";
        echo "  -p– | --path      <path>      (required) | indicate path of your csv file \n";
        echo "  -s  | --separator <separator> (optional) | separator used in your csv file. default value: ',' \n";
        echo "  -h  | --help                             | show this text.\n";
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