<?php
class Wallet_TypeController extends Controller
{
    private $Wallet_TypeModel = NULL;
    public function __construct()
    {
        $this->Wallet_TypeModel = $this->model('Wallet_Type');
    }
    public function getSupportedWallets()
    {
        $supported_wallets = $this->Wallet_TypeModel->getSupportedWallets();
        $result = [];
        if ($supported_wallets->num_rows != 0) {
            $result["success"] = 1;
            while ($row = $supported_wallets->fetch_assoc()) {
                $row["type_logo"] = base64_encode($row["type_logo"]);
                $result["supported_wallets"][] = $row;
            }
        } else $result["success"] = 0;
        return json_encode($result);
    }

    public function displayCurrencies($args = [])
    {
        $currenciesInfo = array();
        $data = $this->Wallet_TypeModel->getSupportedWallets();

        while ($row = $data->fetch_assoc()) {
            $currenciesInfo[] = $row;
        }
        $_SESSION["currenciesInfo"] = $currenciesInfo;
        if (count($args) == 1)
            $this->view('CurrenciesList', $args[0]);
        else $this->view('CurrenciesList');
    }

    public function removeCurrency($currencyID)
    {
        $currencyID = $this->Wallet_TypeModel->connect()->real_escape_string($currencyID);
        $removeCurr = $this->Wallet_TypeModel->deleteWalletType($currencyID);
        if ($removeCurr) {
            $_SESSION["nbrOfCurrencies"] = $this->Wallet_TypeModel->getSupportedWallets()->num_rows;
            $this->displayCurrencies(["<script> alert('Currency successfully removed'); </script>"]);
        } else
            $this->view("AddCurrency", "<script> alert('Cannot remove currency'); </script>");
    }

    public function addCurrency($nameCurrency, $symbolCurrency, $descriptionCurrency)
    {
        $nameCurrency = htmlspecialchars($_POST["nameCurrency"]);
        $symbolCurrency = htmlspecialchars($_POST["symbolCurrency"]);
        $descriptionCurrency = htmlspecialchars($_POST["descriptionCurrency"]);
        $check = getimagesize($_FILES["logoCurrency"]["tmp_name"]);
        if (!empty($nameCurrency) && !empty($symbolCurrency) && $check !== false && !empty($descriptionCurrency)) {
            $nameCurrency = $this->Wallet_TypeModel->connect()->real_escape_string($nameCurrency);
            $symbolCurrency = $this->Wallet_TypeModel->connect()->real_escape_string($symbolCurrency);
            $descriptionCurrency = $this->Wallet_TypeModel->connect()->real_escape_string($descriptionCurrency);
            if ($this->Wallet_TypeModel->getWalletType($nameCurrency)->num_rows != 0) {
                $this->view("AddCurrency", "<script> alert('Currency already exists'); </script>");
            } else {
                $imgData = addslashes(file_get_contents($_FILES['logoCurrency']['tmp_name']));
                $descriptionCurrency = trim($descriptionCurrency);
                $insertCurrency = $this->Wallet_TypeModel->insertWalletType($nameCurrency, $symbolCurrency, $imgData, $descriptionCurrency);
                if ($insertCurrency) {
                    $_SESSION["nbrOfCurrencies"] = $this->Wallet_TypeModel->getSupportedWallets()->num_rows;
                    $this->displayCurrencies(["<script> alert('Currency successfully added'); </script>"]);
                } else $this->view("AddCurrency", "<script> alert('Cannot add currency'); </script>");
            }
        } else $this->view("AddCurrency", "<script> alert('Empty fields'); </script>");;
    }
}
?>