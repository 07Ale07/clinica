document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.procedimientos button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.procedimientos button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            window.odontograma.currentProcedure = this.dataset.procedimiento;
        });
    });
});