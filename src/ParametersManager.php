<?php

class ParametersManager
{
    private string $separator = ",";
    private string $filePath = "";
    private const SHORT_OPTIONS = "p:s:h";
    private const LONG_OPTIONS = array("path:", "separator", "help");

    public function checkOptions()
    {
        $options = getopt(self::SHORT_OPTIONS, self::LONG_OPTIONS);
        if (isset($options["h"]) || isset($options["help"])) {
            $this->printHelp();
        }
        if (isset($options["p"]) || isset($options["path"])) {
            $this->filePath = $options["p"];
        }
        if (isset($options["s"]) || isset($options["separator"])) {
            $this->separator = $options["s"];
        }
        $this->checkFilePath();
    }

    public function getSeparator(): string
    {
        return $this->separator;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    function printHelp(): void
    {
        echo"-------------------------------------------------------\n";
        echo"           script migration parameters\n";
        echo "  -p– | --path      <path>      (required) | indicate path of your csv file \n";
        echo "  -s  | --separator <separator> (optional) | separator used in your csv file. default value: ',' \n";
        echo "  -h  | --help                             | show this text.\n";
        echo "\n";
        echo"-------------------------------------------------------\n";
        exit();
    }

    private function checkFilePath(): void
    {
        if (strlen($this->filePath) == 0) {
            ErrorUtils::SendCriticalError("Please enter a path file with parameter --path <path> or -p <path>. \nFor more information refer to --help command.");
        }
        if (!str_ends_with($this->filePath, ".csv")) {
            ErrorUtils::SendCriticalError("File is not a csv file");
        }
        if (!file_exists($this->filePath)) {
            ErrorUtils::SendCriticalError("file '" . $this->filePath . "' does not exist.");
        }
    }

    public function printAllParameter(): void
    {
        echo "-----------------------------------------------\n";
        echo "               Migrate csv to bdd\n\n";
        printf("   file path: %s\n", $this->filePath);
        printf("   separator: '%s'\n", $this->separator);
        echo "\n-----------------------------------------------\n\n\n";

    }
}