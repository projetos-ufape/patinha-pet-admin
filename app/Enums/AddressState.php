<?php

namespace App\Enums;

enum AddressState: string
{
	case Acre = 'AC';
	case Alagoas = 'AL';
	case Amapa = 'AP';
	case Amazonas = 'AM';
	case Bahia = 'BA';
	case Ceara = 'CE';
	case EspiritoSanto = 'ES';
	case Goias = 'GO';
	case Maranhao = 'MA';
	case MatoGrosso = 'MT';
	case MatoGrossoDoSul = 'MS';
	case MinasGerais = 'MG';
	case Para = 'PA';
	case Paraiba = 'PB';
	case Parana = 'PR';
	case Pernambuco = 'PE';
	case Piaui = 'PI';
	case RioDeJaneiro = 'RJ';
	case RioGrandeDoNorte = 'RN';
	case RioGrandeDoSul = 'RS';
	case Rondonia = 'RO';
	case Roraima = 'RR';
	case SantaCatarina = 'SC';
	case SaoPaulo = 'SP';
	case Sergipe = 'SE';
	case Tocantins = 'TO';
	case DistritoFederal = 'DF';

	public static function values(): array
	{
		return array_map(fn($case) => $case->value, self::cases());
	}
}
