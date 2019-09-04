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

        //Attributes
        $this->RegisterAttributeInteger('SecretNumber', 0);

        //Variables
        $this->RegisterVariableInteger('GuessesLeft', $this->Translate('Moves left'), '', 1);
        $this->RegisterVariableString('YourNumber', $this->Translate('Your number is'), '', 2);
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
            SetValue($this->GetIDForIdent('YourNumber'), $this->Translate('The modulse stopped working'));
        } else {
            $secretNumber = rand($this->ReadPropertyInteger('Min'), $this->ReadPropertyInteger('Max'));
            IPS_SetDisabled($this->GetIDForIdent('YourGuess'), false);

            $this->WriteAttributeInteger('SecretNumber', $secretNumber);
            SetValue($this->GetIDForIdent('YourNumber'), '');
            SetValue($this->GetIDForIdent('YourGuess'), 0);
            SetValue($this->GetIDForIdent('GuessesLeft'), $this->ReadPropertyInteger('CustomGuesses'));
        }
    }

    public function RequestAction($Ident, $Value)
    {
        switch ($Ident) {
            case 'YourGuess':
                if ($this->GetStatus() == 200) {
                    SetValue($this->GetIDForIdent('YourNumber'), $this->Translate('The modulse stopped working'));
                } elseif ($Value == 42) {
                    SetValue($this->GetIDForIdent('YourNumber'), $this->Translate('You win!'));
                    SetValue($this->GetIDForIdent($Ident), $Value);
                    IPS_SetDisabled($this->GetIDForIdent('YourGuess'), true);
                    SetValue($this->GetIDForIdent('GuessesLeft'), 42);
                } else {
                    if ($Value > $this->ReadPropertyInteger('Max') || $Value < $this->ReadPropertyInteger('Min')) {
                        $Min = $this->ReadPropertyInteger('Min');
                        $Max = $this->ReadPropertyInteger('Max');
                        $format = $this->Translate('The number has to be between %d and %d!');
                        SetValue($this->GetIDForIdent('YourNumber'), sprintf($format, $Min, $Max));
                    } else {
                        SetValue($this->GetIDForIdent($Ident), $Value);
                        $guess = GetValue($this->GetIDForIdent('YourGuess'));
                        $secretNumber = $this->ReadAttributeInteger('SecretNumber');
                        $remaining = GetValue($this->GetIDForIdent('GuessesLeft'));

                        if ($remaining >= 1) {
                            if ($guess > $secretNumber) {
                                SetValue($this->GetIDForIdent('YourNumber'), $this->Translate('lower'));
                                $remaining--;
                            } elseif ($guess < $secretNumber) {
                                SetValue($this->GetIDForIdent('YourNumber'), $this->Translate('greater'));
                                $remaining--;
                            } elseif ($guess == $secretNumber) {
                                SetValue($this->GetIDForIdent('YourNumber'), $this->Translate('You win!'));
                                IPS_SetDisabled($this->GetIDForIdent('YourGuess'), true);
                            }
                        }

                        if ($remaining == 0) {
                            $VerlorenText = $this->Translate('You lose! The number was: %d');
                            SetValue($this->GetIDForIdent('YourNumber'), sprintf($VerlorenText, $secretNumber));
                            SetValue($this->GetIDForIdent('GuessesLeft'), 0);
                            IPS_SetDisabled($this->GetIDForIdent('YourGuess'), true);
                            SetValue($this->GetIDForIdent('YourGuess'), $secretNumber);
                        }
                        SetValue($this->GetIDForIdent('GuessesLeft'), $remaining);
                    }
                }
        }
    }
}