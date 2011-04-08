<?php

require_once('jpgraph.php');
require_once('jpgraph_pie.php');
require_once('jpgraph_pie3d.php');
require_once('Vote.class.php');
require_once('VoteCache.class.php');

class PiePage {
	public function processGet($get) {
		ob_clean();

		if (!@ctype_digit($id = $get['id'])) return;

		$graph = new PieGraph(390, 230, 'pie'.$id.'.png');

		try {
			$vc = new VoteCache($id);
		} catch (Exception $e) {
			return;
		}

		$graph->SetShadow();
		$graph->SetAntiAliasing();
		
		$graph->title->Set('Stemresultaten');
		$graph->title->SetFont(FF_VERA);

		$graph->legend->SetFont(FF_VERA, FS_NORMAL, 8);
		
		$p1 = new PiePlot3D(array($vc->vote_0, $vc->vote_1, $vc->vote_2, $vc->vote_3));
		$p1->SetSliceColors(array('green', 'red', 'orange', 'yellow'));
		$p1->SetLegends(array(Vote::getVoteTitleStatic(0),
													Vote::getVoteTitleStatic(1),
													Vote::getVoteTitleStatic(2),
													Vote::getVoteTitleStatic(3)));
		$p1->SetAngle(60);
		$p1->SetHeight(15);
		$p1->SetSize(85);
		$p1->SetCenter(0.37);
		$p1->SetLabelType(PIE_VALUE_ADJPER);
		$p1->value->SetFont(FF_VERA);
		$p1->value->SetFormatCallback(array($this, 'callback'));

		$graph->Add($p1);
		$graph->Stroke();
	}

	public function callback($value) {
		if (0 == $value) return '';
		else return sprintf('%d%%', $value);
	}
}