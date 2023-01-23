<template>
<div class="row col-md-12 flex-wrap justify-content-between" id="contact-container">
    <div class="row card-body cardbody-color justify-content-between" id="form-contact">
        <div class="lead text-center title">
            <h1>Contactez-nous</h1>
            <p>Pour toute information ou aide compléemntaire, veuillez nous contacter en soumettant le formulaire suivant.</p>
        </div>
        <div class="row col-md-6 bloc1">
            <div class="mb-4">
                <label for="name">NOM</label>
                <input type="text" class="form-control" id="name" placeholder="Entrez votre nom ..." formControlName="name"/>
            </div>
        <div class="row col-md-6 bloc2">
            <div class="mb-4">
                <label for="email">EMAIL</label>
                <input type="text" class="form-control" id="email" aria-describedby="email" placeholder="Entrez votre email ..." formControlName="email"/>
            </div>
        </div>
        <div class="mb-4 bloc3">
            <label for="message">MESSAGE</label>
            <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Entrez votre message ..." formControlName="message"></textarea>
        </div>
        <div class="mb-4 d-flex justify-content-center bloc4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" value="client" formControlName="role"/>
                <label class="form-check-label" for="inlineRadio1" style="margin-right: 40px;">JE SUIS UN CLIENT</label>
            </div>
            <div class="form-check form-check-inline justify-content-between">
                <input class="form-check-input" type="radio" id="inlineRadio2" value="tester" formControlName="role"/>
                <label class="form-check-label" for="inlineRadio2">JE SUIS UN CINÉMA</label>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-submit px-6" id="btn-sub">Envoyer</button>
        </div>
    </div>

    <div class="row col-md-6 p-0" id="right-side">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.475368330184!2d2.3896591!3d48.849145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6727347e25d67%3A0xc73e22c1131584f7!2s242%20Rue%20du%20Faubourg%20Saint-Antoine%2C%2075012%20Paris!5e0!3m2!1sfr!2sfr!4v1674430407076!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

</div>
</template>

<style scoped>
#contact-container {
  padding-left: 50px;   
  width: 100%;
  color: var(--color-white);
}

  #form-contact {
    padding: 0
  }

  p {
    margin: 40px;
    font-size: 18px;
  }

  h1 {
    font-weight: bold;
  }

  #btn-sub {
    background-color: var(--color-red);
            color:var(--color-white);
            text-align: center;
            width: 100%;
            height: 50px;
  }

  label {
    font-weight: bold;
    font-size: 18px;
  }

  input {
    background-color: #ffffff30;
    color: var(--color-white);
    border: none;
  }

  textarea {
    background-color: #ffffff30;
    color: var(--color-white);
    border: none;
    height: 150px;
  }

  #right-side {
    margin: 0;
    padding: 0;
  }
</style>