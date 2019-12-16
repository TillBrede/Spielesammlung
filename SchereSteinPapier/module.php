<?php

declare(strict_types=1);
class SchereSteinPapier extends IPSModule
{
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        if (!IPS_VariableProfileExists('SSP.Choice')) {
            IPS_CreateVariableProfile('SSP.Choice', 1);
            IPS_SetVariableProfileValues('SSP.Choice', 0, 0, 0);
            IPS_SetVariableProfileAssociation('SSP.Choice', 0, $this->Translate('Scissors'), 'Transparent', -1);
            IPS_SetVariableProfileAssociation('SSP.Choice', 1, $this->Translate('Rock'), 'Transparent', -1);
            IPS_SetVariableProfileAssociation('SSP.Choice', 2, $this->Translate('Paper'), 'Transparent', -1);
        }
        $this->RegisterVariableString('Result', $this->Translate('Result'), '', 2);
        $this->RegisterVariableInteger('ChoicePlayer', $this->Translate('Your Choice'), 'SSP.Choice', 0);
        $this->EnableAction('ChoicePlayer');
        $this->RegisterVariableInteger('ChoiceCPU', $this->Translate('Computer chose '), 'SSP.Choice', 1);
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
    }

    public function RequestAction($Ident, $Value)
    {
        switch ($Ident) {
            case 'ChoicePlayer':
                SetValue($this->GetIDForIdent($Ident), $Value);
                $choiceP = GetValue($this->GetIDForIdent('ChoicePlayer'));
                $choiceCPU = mt_rand(0, 2);

                switch ($choiceP) {

                case 0:
                    switch ($choiceCPU) {

                    case 0:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('Draw'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    case 1:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('You loose'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    case 2:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('You win'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    default:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('Computer chose a non-existent variable.'));
                    }
                    break;
                case 1:
                    switch ($choiceCPU) {

                    case 0:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('You win'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    case 1:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('Draw'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    case 2:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('You loose'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    default:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('Computer chose a non-existent variable.'));
                    }
                    break;
                case 2:
                    switch ($choiceCPU) {

                    case 0:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('You loose'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    case 1:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('You win'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    case 2:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('Draw'));
                        SetValue($this->GetIDForIdent('ChoiceCPU'), $choiceCPU);
                        break;
                    default:
                        SetValue($this->GetIDForIdent('Result'), $this->Translate('Computer chose a non-existent variable.'));
                        break;
                    }
                break;
            }
        }
    }
}