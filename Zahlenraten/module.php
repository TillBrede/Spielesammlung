<?
class Zahlenraten extends IPSModule {
    
    public function Create(){
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
		
		$this->RegisterPropertyInteger("Max", 15);
		$this->RegisterPropertyInteger("Min", 0);
		$this->RegisterPropertyInteger("ZuegeEdit", 10);
				
		
		if(!IPS_VariableProfileExists("GkG")) {
			IPS_CreateVariableProfile("GkG", 1);
			IPS_SetVariableProfileAssociation("GkG", 0, $this->Translate("lower"), "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 1, $this->Translate("greater"), "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 2, $this->Translate("equal"), "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 3, "", "Transparent", -1 );
			IPS_SetVariableProfileValues("GkG", 0, 2, 1);
		}
		if(!IPS_VariableProfileExists("DeinTipp")) {
			IPS_CreateVariableProfile("DeinTipp", 1);
			IPS_SetVariableProfileValues("DeinTipp", 0, $this->ReadPropertyInteger("Max"), 1);
		}
		
        $this->RegisterAttributeInteger("GeheimeZahl", 0);
		$this->RegisterVariableInteger("ZuegeUebrig", $this->Translate("Moves left"), "", 1);
		$this->RegisterVariableInteger("DeineZahl", $this->Translate("Your number is"), "GkG", 2);
		$this->RegisterVariableInteger("DeinTipp", $this->Translate("Your guess"), "", 3);
		$this->RegisterScript("Generieren", $this->Translate("Generate"), "<?php ZR_Generieren(" . $this->InstanceID . ");", 4);
        $this->EnableAction("DeinTipp");
		
		
    }

    public function Destroy(){
        //Never delete this line!
        parent::Destroy();
        
    }

    public function ApplyChanges(){
        //Never delete this line!
        parent::ApplyChanges();
		
		if ($this->ReadPropertyInteger("Min") > $this->ReadPropertyInteger("Max")) {
			$this->SetStatus(200);
			
		} else {
			$this->SetStatus(102);
		}


    }
	
	

	public function Generieren() {
		
		$Parent = $this->InstanceID;
		if ($this->GetStatus() == 200 ) {
					echo $this->Translate("The modulse stopped working");
		} else {
		$DieZahl = mt_rand($this->ReadPropertyInteger("Min"), $this->ReadPropertyInteger("Max")); 
		IPS_SetDisabled(IPS_GetObjectIDByIdent("DeinTipp", $Parent), false);

		$this->WriteAttributeInteger("GeheimeZahl", $DieZahl);
		SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 3);
		SetValue(IPS_GetObjectIDByIdent("DeinTipp", $Parent), 0);
		SetValue($this->GetIDForIdent("ZuegeUebrig"), $this->ReadPropertyInteger("ZuegeEdit"));
		}
	
	}
	
	public function RequestAction($Ident, $Value) {
		
		$Parent = $this->InstanceID;
		
		switch ($Ident) {
			case "DeinTipp":
				if ($this->GetStatus() == 200 ) {
					echo $this->Translate("The modulse stopped working");
				} else {		
			
					if ($Value > $this->ReadPropertyInteger("Max") || $Value < $this->ReadPropertyInteger("Min")) {
						$Min = $this->ReadPropertyInteger("Min");
						$Max = $this->ReadPropertyInteger("Max");
						$MiniMax = $this->Translate("The number has to be between %d and %d!");
						echo sprintf($MiniMax, $Min, $Max);
					} else {
						SetValue($this->GetIDForIdent($Ident), $Value);
						$Tipp = GetValue($this->GetIDForIdent("DeinTipp"));
						$DieZahl = $this->ReadAttributeInteger("GeheimeZahl");
						$Verbleibend = GetValue($this->GetIDForIdent("ZuegeUebrig"));

						if ($Verbleibend >= 1) {
							if ($Tipp > $DieZahl) {
								SetValue($this->GetIDForIdent("DeineZahl"), 0);
								$Verbleibend--;
							} elseif($Tipp < $DieZahl) {
								SetValue($this->GetIDForIdent("DeineZahl"), 1);
								$Verbleibend--;
							} elseif($Tipp = $DieZahl) {
								SetValue($this->GetIDForIdent("DeineZahl"), 2);
								echo $this->Translate("You win!");
								IPS_SetDisabled($this->GetIDForIdent("DeinTipp"), true);
							}
						}

						if($Verbleibend == 0) {
							$VerlorenText = $this->Translate("You lose!\n\nThe number was: %d");						
							echo sprintf($VerlorenText, $DieZahl);
							SetValue($this->GetIDForIdent("ZuegeUebrig"), 0);
							IPS_SetDisabled($this->GetIDForIdent("DeinTipp"), true);
						}
						SetValue($this->GetIDForIdent("ZuegeUebrig"), $Verbleibend);
					}
				}
		}
	
	}  	

}
?>