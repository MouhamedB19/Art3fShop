<?php


namespace App\Mail;

use App\Calculs\CalculeReduction;
use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandeConfirmee extends Mailable
{
    use Queueable, SerializesModels,CalculeReduction;
    public Commande $commande;
    public float $totalBrut;
    public float $reduction;
    public float $totalNet;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
        $this->totalBrut = 0; //à modifier pour inclure taux_reduction
        foreach($commande->tirages as $tirage)
        {
            $this->totalBrut += $tirage->oeuvre->taux_reduction ? $tirage->prix *(1 - $tirage->oeuvre->taux_reduction) : $tirage->prix;
        }
        $this->reduction = $this->calculerReduction($this->totalBrut, $commande->coupons);
        $this->totalNet = $this->totalBrut - $this->reduction;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre commande #' . $this->commande->id)
            ->markdown('emails.commande-confirmee');
    }
}
