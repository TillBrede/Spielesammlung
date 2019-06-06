<?
class SchereSteinPapier extends IPSModule {
    
    public function Create(){
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
		If(!IPS_VariableProfileExists("SSP")) {
			IPS_CreateVariableProfile("SSP", 1);
			IPS_SetVariableProfileValues("SSP", 0, 0, 1);
			IPS_SetVariableProfileAssociation("SSP", 0, "Schere", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("SSP", 1, "Stein", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("SSP", 2, "Papier", "Transparent", -1 );
		} else {
		}
        $this->RegisterVariableInteger("WahlS", "Deine Wahl:", "SSP", 0);
        $this->EnableAction("WahlS");
		
    }

    public function Destroy(){
        //Never delete this line!
        parent::Destroy();
        
    }

    public function ApplyChanges(){
        //Never delete this line!
        parent::ApplyChanges();
    }
	
		
	
	public function RequestAction($Ident, $Value) {
		
		$Parent = $this->InstanceID;
		
		switch ($Ident) {
			case "WahlS":
				SetValue(IPS_GetObjectIDByIdent($Ident, $Parent), $Value);
				$WahlS = GetValue(IPS_GetObjectIDByIdent("WahlS", $Parent));
				$WahlC = mt_rand(0, 2); 

			

				switch($WahlS) {

				case 0:
					switch($WahlC){
					
					case 0:
						echo "Unentschieden";
						break;
					case 1:
						echo "Verloren\n" . "Computer wählte " . $this->GetComputerW($WahlC);
						break;
					case 2:
						echo "Gewonnen\n" . "Computer wählte " . $this->GetComputerW($WahlC);
						break;
					default:
						echo "Computer wählte eine nicht existente Variable";
					}
					break;
				case 1:
					switch($WahlC){
					
					case 0:
						echo "Gewonnen\n" . "Computer wählte " . $this->GetComputerW($WahlC);
						break;
					case 1:
						echo "Unentschieden";
						break;
					case 2:
						echo "Verloren\n" . "Computer wählte " . $this->GetComputerW($WahlC);
						break;
					default:
						echo "Computer wählte eine nicht existente Variable";
					}
					break;
				case 2:
					switch($WahlC){
					
					case 0:
						echo "Verloren\n" . "Computer wählte " . $this->GetComputerW($WahlC);
						break;
					case 1:
						echo "Gewonnen\n" . "Computer wählte " . $this->GetComputerW($WahlC);
						break;
					case 2:
						echo "Unentschieden";
						break;
					default:
						echo "Computer wählte eine nicht existente Variable";
						break;
					}
				break;
				}   
		} 			
	}	
	
	private function GetComputerW($Wahl) {
		switch($Wahl){
			case 0:
				$Gegenstand = "Schere";
				break;
			case 1:
				$Gegenstand = "Stein";
				break;
			case 2:
				$Gegenstand = "Papier";
				break;
		}
		return $Gegenstand;
	}  

}
?>