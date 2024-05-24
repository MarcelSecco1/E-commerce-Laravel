<?php

namespace App\Livewire;

use App\Models\CodePromotion as ModelsCodePromotion;
use App\Models\User;
use App\Models\UserCode;
use Livewire\Attributes\On;
use Livewire\Component;

class CodePromotion extends Component
{
    public String $code;
    private $codePromotion;

    public function render()
    {
        return view('livewire.code-promotion');
    }

    public function applyCode()
    {
        if(!auth()->check()){
            return $this->dispatch('error', 'Você precisa estar logado para aplicar um código');
        }


        if ($this->code) {
            $this->codePromotion = ModelsCodePromotion::where('code', $this->code)->first();

            if (!$this->codePromotion) {
                return $this->dispatch('error', 'Código inválido');
            }

            if ($this->codePromotion->limit_usage_per_user > 0) {
                $user = auth()->user();

                $userCode = UserCode::where('user_id', $user->id)
                    ->where('code_promotions_id', $this->codePromotion->id)
                    ->where('used', 1)
                    ->count();

                if ($userCode >= $this->codePromotion->limit_usage_per_user) {
                    return $this->dispatch('error', 'Você já utilizou o limite de uso desse código');
                }
            }

            $this->dispatch('success', 'Código aplicado com sucesso!');
            $this->dispatch('applyCodeInCart', discount: $this->codePromotion->discount);
        }
    }

    #[On('applyCodeInUser')]
    public function applyCodeInUser()
    {
        if (!$this->codePromotion) {
            return;
        }

        if ($this->codePromotion->limit_usage_per_user > 0) {
            $user = auth()->user();

            $userCode = UserCode::where('user_id', $user->id)
                ->where('code_promotions_id', $this->codePromotion->id)
                ->where('used', 1)
                ->count();

            if ($userCode >= $this->codePromotion->limit_usage_per_user) {
                return $this->dispatch('error', 'Você já utilizou o limite de uso desse código');
            }
        }
        UserCode::create([
            'user_id' => $user->id,
            'code_promotions_id' => $this->codePromotion->id,
            'used' => 1
        ]);
    }
}
