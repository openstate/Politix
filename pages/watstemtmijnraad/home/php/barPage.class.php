<?php

require_once('jpgraph.php');
require_once('jpgraph_bar.php');
require_once('Vote.class.php');
require_once('PartyVoteCache.class.php');

class BarPage {
	private $colors = array('green', 'red', 'orange1', 'yellow1');
	private $darkColors = array('darkgreen', 'darkred', 'orange4', 'yellow4');

	public function processGet($get) {
		ob_clean();

		if (!@ctype_digit($id = $get['id'])) return;

		$graph = new Graph(0, 0, 'bar'.$id.'.png'); //Create dummy for caching

		try {
			$v = new PartyVoteCache();
			$list = $v->loadVotesList($id, 'ORDER BY party_name ASC');
			if (count($list) == 0) return;
		} catch (Exception $e) {
			return;
		}

		$graph->img->CreateImgCanvas(80 + 40*count($list), 350); // Replace image 

		$data = array();

		foreach ($list as $item) {
			$data[0][] = $item->vote_0;
			$data[1][] = $item->vote_1;
			$data[2][] = $item->vote_2;
			$data[3][] = $item->vote_3;
			if (null == $item->party_short_name) {
			  if (strlen($item->party_name) > 14)
					$names[] = substr($item->party_name, 0, 11) . '...';
				else
					$names[] = $item->party_name;
			} else {
				$names[] = $item->party_short_name;
			}
		}

		$graph->SetScale('textlin');
		$graph->SetShadow();

		$graph->yaxis->SetFont(FF_VERA, FS_BOLD);
		$graph->yaxis->scale->SetGrace(10);
		$graph->yaxis->SetLabelFormatCallback(array($this, 'callback')); 

		$graph->xaxis->SetTickLabels($names);
		$graph->xaxis->SetFont(FF_VERA, FS_NORMAL, 8);
		$graph->xaxis->SetLabelAngle(-45);
		$graph->xaxis->SetLabelMargin(5); 
		$graph->xaxis->SetLabelAlign('left','top');

		$graph->legend->SetFont(FF_VERA, FS_NORMAL, 8);
		$graph->legend->SetPos(0.05, 0.01);

		$graph->img->SetMargin(40,40,40,80);

		$plots = array();

		for ($i = 0; $i < 4; $i++) {
			$plot = &$plots[];
			$plot = new BarPlot($data[$i]);
			//$plot->SetFillColor($this->colors[$i]);
			$plot->SetFillGradient($this->darkColors[$i], $this->colors[$i], GRAD_MIDVER);
			$plot->SetLegend(Vote::getVoteTitleStatic($i));
		}

		$graph->Add(new AccBarPlot($plots));
		$graph->legend->SetReverse();

		// Display the graph
		$graph->Stroke();
	}

	public function callback($value) {
		if (strpos((string)$value, '.') !== false) return '';
		else return sprintf('%.0f', $value);
	}
}

