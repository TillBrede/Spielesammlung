<?php

declare(strict_types=1);
class Zahlenraten extends IPSModule
{
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        //Properties
        $this->RegisterPropertyInteger('Max', 15);
        $this->RegisterPropertyInteger('Min', 0);
        $this->RegisterPropertyInteger('CustomGuesses', 10);

        //Profiles
        if (!IPS_VariableProfileExists('ZR.ComparisonOperators')) {
            IPS_CreateVariableProfile('ZR.ComparisonOperators', 1);
            IPS_SetVariableProfileAssociation('ZR.ComparisonOperators', 0, $this->Translate('lower'), 'Transparent', -1);
            IPS_SetVariableProfileAssociation('ZR.ComparisonOperators', 1, $this->Translate('greater'), 'Transparent', -1);
            IPS_SetVariableProfileAssociation('ZR.ComparisonOperators', 2, $this->Translate('equal'), 'Transparent', -1);
            IPS_SetVariableProfileAssociation('ZR.ComparisonOperators', 3, '', 'Transparent', -1);
            IPS_SetVariableProfileValues('ZR.ComparisonOperators', 0, 2, 1);
        }

        //Attributes
        $this->RegisterAttributeInteger('SecretNumber', 0);

        //Variables
        $this->RegisterVariableInteger('GuessesLeft', $this->Translate('Moves left'), '', 1);
        $this->RegisterVariableInteger('YourNumber', $this->Translate('Your number is'), 'ZR.ComparisonOperators', 2);
        $this->RegisterVariableInteger('YourGuess', $this->Translate('Your guess'), '', 3);
        $this->EnableAction('YourGuess');

        //Scripts
        $this->RegisterScript('Generate', $this->Translate('Generate'), '<?php ZR_Generate(IPS_GetParent($_IPS[\'SELF\'])); ?>', 4);
    }

    public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

        if ($this->ReadPropertyInteger('Min') > $this->ReadPropertyInteger('Max')) {
            $this->SetStatus(200);
        } else {
            $this->SetStatus(102);
        }
    }

    public function Generate()
    {
        if ($this->GetStatus() == 200) {
            echo $this->Translate('The modulse stopped working');
        } else {
            $secretNumber = rand($this->ReadPropertyInteger('Min'), $this->ReadPropertyInteger('Max'));
            IPS_SetDisabled($this->GetIDForIdent('YourGuess'), false);

            $this->WriteAttributeInteger('SecretNumber', $secretNumber);
            SetValue($this->GetIDForIdent('YourNumber'), 3);
            SetValue($this->GetIDForIdent('YourGuess'), 0);
            SetValue($this->GetIDForIdent('GuessesLeft'), $this->ReadPropertyInteger('CustomGuesses'));
        }
    }

    public function RequestAction($Ident, $Value)
    {
        switch ($Ident) {
            case 'YourGuess':
                if ($this->GetStatus() == 200) {
                    echo $this->Translate('The modulse stopped working');
                } else {
                    if ($Value > $this->ReadPropertyInteger('Max') || $Value < $this->ReadPropertyInteger('Min')) {
                        $Min = $this->ReadPropertyInteger('Min');
                        $Max = $this->ReadPropertyInteger('Max');
                        $format = $this->Translate('The number has to be between %d and %d!');
                        echo sprintf($format, $Min, $Max);
                    } else {
                        SetValue($this->GetIDForIdent($Ident), $Value);
                        $guess = GetValue($this->GetIDForIdent('YourGuess'));
                        $secretNumber = $this->ReadAttributeInteger('SecretNumber');
                        $remaining = GetValue($this->GetIDForIdent('GuessesLeft'));

                        if ($remaining >= 1) {
                            if ($guess > $secretNumber) {
                                SetValue($this->GetIDForIdent('YourNumber'), 0);
                                $remaining--;
                            } elseif ($guess < $secretNumber) {
                                SetValue($this->GetIDForIdent('YourNumber'), 1);
                                $remaining--;
                            } elseif ($guess == $secretNumber) {
                                SetValue($this->GetIDForIdent('YourNumber'), 2);
                                echo $this->Translate('You win!');
                                IPS_SetDisabled($this->GetIDForIdent('YourGuess'), true);
                            }
                        }

                        if ($remaining == 0) {
                            $VerlorenText = $this->Translate("You lose!\n\nThe number was: %d");
                            echo sprintf($VerlorenText, $secretNumber);
                            SetValue($this->GetIDForIdent('GuessesLeft'), 0);
                            IPS_SetDisabled($this->GetIDForIdent('YourGuess'), true);
                        }
                        SetValue($this->GetIDForIdent('GuessesLeft'), $remaining);
                    }
                }
        }
    }
}