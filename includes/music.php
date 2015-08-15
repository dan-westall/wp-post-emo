<?php





$demo = [[8, 85],[8, 71], [2, 162], [9, 133], [8, 215], [1, 157], [2, 20], [8, 192], [9, 269], [2, 22], [9, 279], [8, 248], [8, 86], [2, 11], [2, 38], [2, 135], [2, 168], [2, 42], [2, 11], [8, 69], [8, 140]];

class WP_Post_Emo_Music {



	private $noteLength = 6;
	private $notes = [
		"1" => "START On ch=2 n=77 v=62
			    END Off ch=2 n=77 v=28",
		"2" => "START On ch=2 n=78 v=72
				END Off ch=2 n=78 v=44",
		"3" => "START On ch=2 n=79 v=77
				END Off ch=2 n=79 v=44",
		"4" => "START On ch=2 n=80 v=85
				END Off ch=2 n=80 v=40",
		"5" => "START On ch=2 n=81 v=75
				END Off ch=2 n=81 v=41",
		"6" => "START On ch=2 n=82 v=83
				END Off ch=2 n=82 v=55",
		"7" => "START On ch=2 n=83 v=80
				END Off ch=2 n=83 v=48",
		"8" => "START On ch=2 n=84 v=62
				END Off ch=2 n=84 v=33",
		"9" => "START On ch=2 n=85 v=83
				END Off ch=2 n=85 v=56",
		"10" => "START On ch=2 n=86 v=85
				 END Off ch=2 n=86 v=31"	
	];

	/**
	 * WP_Post_Emo_Music constructor.
	 */
	public function __construct( WP_Post_Emo_Plugin $plugin ) {

        $this->plugin = $plugin;

	}


	public function generateSong($txt) {

		require $this->plugin->includes_path.  'libraries/midi/classes/midi.class.php';

		$visible = true;
		$autostart = true;
		$loop = false;
		$player = "mp3_flash";

		$wp_upload_dir = wp_upload_dir();

		$save_dir = $wp_upload_dir['path'] . '/';
		srand((double)microtime()*1000000);

		$file_name = rand();
		$file = $save_dir.$file_name.'.mid';

		$midi = new Midi();
		$midi->importTxt($txt);
		$midi->saveMidFile($file, 0666);
		
		return $file_name . '.mid';
	}

	private function generateMIDItxt($input) {
		$time = 0;
		$outputStart = 'MFile 1 5 480
						MTrk
						0 SeqSpec 00 00 41
						0 Meta Text "Sequence"
						0 SMPTE 96 0 10 0 0
						0 TimeSig 4/4 24 8
						0 Tempo 500000
						0 Meta TrkEnd
						TrkEnd
						MTrk
						0 Meta Text "Fantasia 2"
						0 Par ch=2 c=6 v=0
						0 Par ch=2 c=7 v=100
						0 Par ch=2 c=64 v=0
						0 Pb ch=2 v=8192
						0 PrCh ch=2 p=88';
		$outputBody = "";			
		$outputEnd =   'END Pb ch=2 v=8192
						END Par ch=2 c=64 v=0
						END Par ch=2 c=7 v=100
						END Par ch=2 c=6 v=0
						END Meta TrkEnd
						TrkEnd';


		foreach ($input as $note) {
			$pitch = $note[0];
			$length = $note[1] * $this->noteLength;
			
			$start = $time;
			$time = $time + $length;
	

			$noteTXT = $this->notes[$pitch] . "\n";
			
			$convertBefore = ["START", "END"];	
			$convertAfter = [$start, $time];
	
			$noteTXTConverted = str_replace($convertBefore, $convertAfter, $noteTXT);
			$outputBody = $outputBody . $noteTXTConverted;

		}

		$outputEnd = str_replace("END", $time, $outputEnd);
		return $outputStart . "\n" . $outputBody . $outputEnd;
	}

	public function generate($input) {
		$MIDItxt = self::generateMIDItxt($input);
		echo nl2br($MIDItxt);

		return self::generateSong($MIDItxt);
	}

}


?>