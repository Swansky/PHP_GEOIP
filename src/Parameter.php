<?php

class Parameter
{
    public static int $CLASSIC_METHOD = 0;
    public static int $FAST_METHOD = 1;
    private string $separator = ",";
    private string $endCsvLineString = "\n";
    private string $csvPath = "";
    private int $methodUsed = 0;


    public function checkParameters(): void
    {
        if (strlen($this->csvPath) == 0) {
            ErrorUtils::SendCriticalError("Please enter a path file with parameter --path <path> or -p <path>. \nFor more information refer to --help command.");
        }
        if (!str_ends_with($this->csvPath, ".csv")) {
            ErrorUtils::SendCriticalError("File is not a csv file");
        }
        if (!file_exists($this->csvPath)) {
            ErrorUtils::SendCriticalError("file '" . $this->csvPath . "' does not exist.");
        }
        if (strlen($this->separator) == 0) {
            ErrorUtils::SendCriticalError("Separator can't be empty.");
        }
        if (strlen($this->endCsvLineString) == 0) {
            ErrorUtils::SendCriticalError("end line for csv can't be empty. use parameter --end <end character> to set this value. default: '\\n'");
        }
        if (!$this->methodUsed == self::$CLASSIC_METHOD && !$this->methodUsed == self::$FAST_METHOD) {
            ErrorUtils::SendCriticalError("Invalid method. refer to --help for more information.");
        }
    }

    public function printAllParameter(): void
    {
        echo "-----------------------------------------------\n";
        echo "               Migrate csv to bdd\n\n";
        printf("   file path: %s\n", $this->csvPath);
        printf("   separator: '%s'\n", $this->separator);
        printf("   method used: %s", $this->methodToString());
        echo "\n-----------------------------------------------\n\n\n";

    }

    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     */
    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    /**
     * @return string
     */
    public function getEndCsvLineString(): string
    {
        return $this->endCsvLineString;
    }

    /**
     * @param string $endCsvLineString
     */
    public function setEndCsvLineString(string $endCsvLineString): void
    {
        $this->endCsvLineString = $endCsvLineString;
    }

    /**
     * @return string
     */
    public function getCsvPath(): string
    {
        return $this->csvPath;
    }

    /**
     * @param string $csvPath
     */
    public function setCsvPath(string $csvPath): void
    {
        $this->csvPath = $csvPath;
    }

    /**
     * @return int
     */
    public function getMethodUsed(): int
    {
        return $this->methodUsed;
    }

    /**
     * @param int $methodUsed
     */
    public function setMethodUsed(int $methodUsed): void
    {
        $this->methodUsed = $methodUsed;
    }

    public function methodToString(): string
    {
        switch ($this->methodUsed) {
            case self::$CLASSIC_METHOD:
                return "Classic";
                break;
            case self::$FAST_METHOD:
                return "Fast";
                break;
        }
        ErrorUtils::SendCriticalError("No string define for this method !");
    }


}