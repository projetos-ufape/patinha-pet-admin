<?php

namespace App\Enums;

enum AddressState: string
{
	case Acre = 'acre';
	case Alagoas = 'alagoas';
	case Amapa = 'amapa';
	case Amazonas = 'amazonas';
	case Bahia = 'bahia';
	case Ceara = 'ceara';
	case EspiritoSanto = 'espiritosanto';
	case Goias = 'goias';
	case Maranhao = 'maranhao';
	case MatoGrosso = 'matogrosso';
	case MatoGrossoDoSul = 'matogrossodosul';
	case MinasGerais = 'minasgerais';
	case Para = 'para';
	case Paraiba = 'paraiba';
	case Parana = 'parana';
	case Pernambuco = 'pernambuco';
	case Piaui = 'piaui';
	case RioDeJaneiro = 'riodejaneiro';
	case RioGrandeDoNorte = 'riograndedonorte';
	case RioGrandeDoSul = 'riograndedosul';
	case Rondonia = 'rondonia';
	case Roraima = 'roraima';
	case SantaCatarina = 'santacatarina';
	case SaoPaulo = 'saopaulo';
	case Sergipe = 'sergipe';
	case Tocantins = 'tocantins';
	case DistritoFederal = 'distritofederal';

	public static function values(): array
	{
		return array_map(fn($case) => $case->value, self::cases());
	}
}