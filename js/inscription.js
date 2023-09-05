function toggleFields() {
    const statut = document.getElementById("statut");
    const prenom = document.getElementById("prenom");
    const date = document.getElementById("date_de_naissance");
    const prenomLabel = document.getElementById("prenom-label");
    const dateLabel = document.getElementById("date-label");
    const jobCandidateLabel = document.getElementById("job-candidat-label")
    const jobCandidate = document.getElementById("job-candidat");

    if (statut.value == 2) {
        prenom.style.display = "none";
        prenom.removeAttribute("required");
        date.style.display = "none";
        date.removeAttribute("required");
        prenomLabel.style.display = "none";
        dateLabel.style.display = "none";
        jobCandidateLabel.style.display = "none";
        jobCandidate.style.display = "none";
        jobCandidate.removeAttribute("required");
    } else {
        prenom.style.display = "block";
        prenom.setAttribute("required", true);
        date.style.display = "block";
        date.setAttribute("required", true);
        prenomLabel.style.display = "block";
        dateLabel.style.display = "block";
        jobCandidateLabel.style.display = "block";
        jobCandidate.style.display = "block";
        jobCandidate.setAttribute("required", true);
    }
}