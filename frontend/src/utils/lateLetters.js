export const isLate = (letterDate, thresholdDays = 7, status = '') => {
    if (!letterDate) return false;
    
    // Normalize status check
    const isReplied = status && (
        status.toLowerCase() === 'replied' || 
        status.includes('تم الرد')
    );
    
    if (isReplied) return false;
    
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const lDate = new Date(letterDate);
    // Add threshold days to letter date
    lDate.setDate(lDate.getDate() + parseInt(thresholdDays));
    
    // If deadline (letterDate + threshold) is before today, it's late
    return lDate < today;
};

export const overdueDays = (letterDate, thresholdDays) => {
    if (!letterDate) return 0;
    
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const lDate = new Date(letterDate);
    // Deadline is letter date + threshold
    const deadline = new Date(lDate);
    deadline.setDate(deadline.getDate() + parseInt(thresholdDays));
    
    if (deadline >= today) return 0;
    // Calculate difference in days
    const diffTime = Math.abs(today - deadline);
    console.log(Math.ceil(diffTime / (1000 * 60 * 60 * 24)))
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
};
