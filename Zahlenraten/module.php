<?
class Zahlenraten extends IPSModule {
    
    public function Create(){
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
		
		if(!IPS_VariableProfileExists("Zuege")) {
			IPS_CreateVariableProfile("Zuege", 1);
			IPS_SetVariableProfileValues("Zuege", 0, 5, 1);
		}
		if(!IPS_VariableProfileExists("GkG")) {
			IPS_CreateVariableProfile("GkG", 1);
			IPS_SetVariableProfileAssociation("GkG", 0, "kleiner", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 1, "größer", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 2, "gleich", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 3, "", "Transparent", -1 );
			IPS_SetVariableProfileValues("GkG", 0, 2, 1);
		}
		if(!IPS_VariableProfileExists("DeinTipp")) {
			IPS_CreateVariableProfile("DeinTipp", 1);
			IPS_SetVariableProfileAssociation("DeinTipp", 0, "0", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 1, "1", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 2, "2", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 3, "3", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 4, "4", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 5, "5", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 6, "6", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 7, "7", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 8, "8", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 9, "9", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("DeinTipp", 10, "10", "Transparent", -1 );
			IPS_SetVariableProfileValues("DeinTipp", 0, 10, 0);
		}
		
        $this->RegisterAttributeInteger("GeheimeZahl", 0);
		$this->RegisterVariableInteger("ZuegeUebrig", "ZügeÜbrig", "Zuege", 1);
		$this->RegisterVariableInteger("DeineZahl", "Deines Zahl ist", "GkG", 2);
		$this->RegisterVariableInteger("DeinTipp", "DeinTipp", "DeinTipp", 3);
		$this->RegisterScript("Generieren", "Generieren", "<?php ZR_Generieren(" . $this->InstanceID . ");", 4);
        $this->EnableAction("DeinTipp");
		
		
    }

    public function Destroy(){
        //Never delete this line!
        parent::Destroy();
        
    }

    public function ApplyChanges(){
        //Never delete this line!
        parent::ApplyChanges();
    }
	
	

	public function Generieren() {
		
		$Parent = $this->InstanceID;
		$DieZahl = mt_rand(0, 10); 
		IPS_SetDisabled(IPS_GetObjectIDByIdent("DeinTipp", $Parent), false);

		$this->WriteAttributeInteger("GeheimeZahl", $DieZahl);
		SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 3);
		SetValue(IPS_GetObjectIDByIdent("DeinTipp", $Parent), 0);
		SetValue(IPS_GetObjectIDByIdent("ZuegeUebrig", $Parent), 5);
	
	}
	
	public function RequestAction($Ident, $Value) {
		
		$Parent = $this->InstanceID;
		
		switch ($Ident) {
			case "DeinTipp":
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
						echo "Gewonnen!";
						IPS_SetDisabled($this->GetIDForIdent("DeinTipp"), true);
					}
				}

				if($Verbleibend == 0) {
					echo "Verloren!" . "\n\nDie Zahl war: " . $DieZahl ;
					SetValue($this->GetIDForIdent("ZuegeUebrig"), 0);
					IPS_SetDisabled($this->GetIDForIdent("DeinTipp"), true);
				}

		
					SetValue($this->GetIDForIdent("ZuegeUebrig"), $Verbleibend);
		}
	}  	

}
?>