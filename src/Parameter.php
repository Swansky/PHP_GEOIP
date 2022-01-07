<?php

class Parameter
{
    private string $separator = ",";
    private string $endCsv = "\n";
    private string $csvPath = "";


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
    }

    public function printAllParameter(): void
    {
        echo "-----------------------------------------------\n";
        echo "               Migrate csv to bdd\n\n";
        printf("   file path: %s\n", $this->csvPath);
        printf("   separator: '%s'\n", $this->separator);
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
    public function getEndCsv(): string
    {
        return $this->endCsv;
    }

    /**
     * @param string $endCsv
     */
    public function setEndCsv(string $endCsv): void
    {
        $this->endCsv = $endCsv;
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


}