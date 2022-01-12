<?php

class Parameter
{
    public static int $CLASSIC_METHOD = 0;
    public static int $FAST_METHOD = 1;
    private string $separator = ",";
    private string $endCsvLineString = "\n";
    private string $csvPath = "";
    private int $methodUsed = 0;
    private string $bddHost = "127.0.0.1";
    private string $bddUsername = "root";
    private string $bddPassword = "example";
    private string $bddName = "tp-geoip";

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
        return "";
    }

    /**
     * @return string
     */
    public function getBddHost(): string
    {
        return $this->bddHost;
    }

    /**
     * @param string $bddHost
     */
    public function setBddHost(string $bddHost): void
    {
        $this->bddHost = $bddHost;
    }

    /**
     * @return string
     */
    public function getBddUsername(): string
    {
        return $this->bddUsername;
    }

    /**
     * @param string $bddUsername
     */
    public function setBddUsername(string $bddUsername): void
    {
        $this->bddUsername = $bddUsername;
    }

    /**
     * @return string
     */
    public function getBddPassword(): string
    {
        return $this->bddPassword;
    }

    /**
     * @param string $bddPassword
     */
    public function setBddPassword(string $bddPassword): void
    {
        $this->bddPassword = $bddPassword;
    }

    /**
     * @return string
     */
    public function getBddName(): string
    {
        return $this->bddName;
    }

    /**
     * @param string $bddName
     */
    public function setBddName(string $bddName): void
    {
        $this->bddName = $bddName;
    }

    public function loadDatabaseConfigFile(string $configFilePath)
    {
        if (file_exists($configFilePath) || is_readable($configFilePath)) {
            $content = file_get_contents($configFilePath);
            $json = json_decode($content);
            foreach ($json as $key => $val) {
                switch ($key) {
                    case "host":
                        $this->bddHost = $val;
                        break;
                    case "username":
                        $this->bddUsername = $val;
                        break;
                    case "password":
                        $this->bddPassword = $val;
                        break;
                }
            }
        } else {
            ErrorUtils::SendCriticalError(sprintf("The config file '%s' does not exist or not readable", $configFilePath));
        }
    }


}