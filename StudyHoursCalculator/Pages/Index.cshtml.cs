using System.ComponentModel.DataAnnotations;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace StudyHoursCalculator.Pages;

public class IndexModel : PageModel
{
    [BindProperty]
    [Required(ErrorMessage = "Enter your study hours per day.")]
    [Range(typeof(decimal), "0", "24",
        ErrorMessage = "Hours per day must be between 0 and 24.")]
    [Display(Name = "Study hours per day")]
    public decimal? HoursPerDay { get; set; }

    [BindProperty]
    [Required(ErrorMessage = "Enter the number of days.")]
    [Range(1, 365, ErrorMessage = "Days must be between 1 and 365.")]
    [Display(Name = "Number of days")]
    public int? Days { get; set; }

    public decimal? TotalHours { get; private set; }

    public void OnGet()
    {
    }

    public void OnPost()
    {
        if (!ModelState.IsValid)
        {
            return;
        }

        TotalHours = HoursPerDay!.Value * Days!.Value;
    }
}