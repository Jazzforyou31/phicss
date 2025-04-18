$(document).ready(function () {
    $('#addTransparencyBtn').click(function () {
        $.ajax({
            url: '../../views/adminModals/addTransparencyModal.html',
            type: 'GET',
            success: function (data) {
                $('#addTransparencyModal').remove();
                $('body').append(data);
                $('#addTransparencyModal').modal('show');

                // Fetch school years when modal is loaded
                $.ajax({
                    url: '../../views/adminModals/getSchoolYears.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            const $select = $('#schoolYear');
                            $select.empty().append('<option value="">Select school year</option>');
                            response.data.forEach(sy => {
                                $select.append(`<option value="${sy.school_year_id}">${sy.school_year}</option>`);
                            });
                            
                        } else {
                            console.error('No school years found:', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching school years:', error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Error loading modal:", error);
            }
        });
    });


// Filter transparency sections by section
// Filter transparency sections by school year
$(document).on('change', '#schoolYearFilter', function () {
    const selectedYear = $(this).val(); // Get the selected school year value

    $.ajax({
        url: '../../views/adminModals/getTransparencyBySection.php', // Ensure the correct endpoint
        type: 'GET',
        data: { school_year_id: selectedYear },  // Pass the selected school year ID
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const container = $('#transparencySectionsContainer');
                container.empty();

                // Append the transparency sections
                response.data.forEach(section => {
                    container.append(`
                        <div class="main-container">
                            <div class="icon-container">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="action-icons">
                                <button class="view-btn" data-id="${section.id}">
                                    <i class="fas fa-pencil-alt" style="color: var(--warning);"></i>
                                </button>
                                <button class="delete-btn" data-id="${section.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="inner-container">
                                <div class="section-title">
                                    <h3>${section.section_title}</h3>
                                </div>
                                <div class="content-links">
                                    ${section.links.length ? section.links.map(link => `
                                        <a href="${link.document_link}" target="_blank">${link.document_title}</a>
                                    `).join('') : '<p>No links available for this section.</p>'}
                                </div>
                                <button class="btn btn-outline-primary btn-sm mt-2 addLinkBtn" style="width: 100px;" data-section-id="${section.id}">
                                    <i class="fas fa-plus"></i> Link
                                </button>
                            </div>
                        </div>
                    `);
                });

                // If no sections are found, show a message
                if (response.data.length === 0) {
                    container.append('<p>No transparency data found for the selected school year.</p>');
                }
            } else {
                console.error('Error loading transparency data:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});




    // Load school years into the filter dropdown on page load
    $(document).ready(function() {
        $.ajax({
            url: '../../views/adminModals/getSchoolYears.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const schoolYearDropdown = $('#schoolYearFilter');
                    schoolYearDropdown.empty();  // Clear existing options
                    schoolYearDropdown.append('<option value="">All School Years</option>');  // Default option
    
                    response.data.forEach(function(schoolYear) {
                        schoolYearDropdown.append('<option value="' + schoolYear.school_year_id + '">' + schoolYear.school_year + '</option>');
                    });
                } else {
                    console.error('Error loading school years:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });
    



    $('#schoolYearFilter').on('change', function () {
        const selectedYear = $(this).val();
    
        // Example: If you're loading sections dynamically with AJAX, call it here:
        loadTransparencySections(selectedYear); // You define this function
    
        // Or filter existing sections manually:
        $('.transparency-section').each(function () {
            const sectionYear = $(this).data('school-year-id');
            if (!selectedYear || sectionYear == selectedYear) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    



    // Handle Section Form Submission
    $(document).on('submit', '#addSectionForm', function (e) {
        e.preventDefault();
        const sectionTitle = $('#sectionTitle').val().trim();
        const schoolYearId = $('#schoolYear').val();

        if (!sectionTitle || !schoolYearId) {
            alert('Section title and school year are required.');
            return;
        }

        $.ajax({
            url: '../../views/adminModals/addTransparency.php',
            type: 'POST',
            data: {
                action: 'add_section',
                section_title: sectionTitle,
                school_year_id: schoolYearId
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    alert('Section added!');
                    $('#addTransparencyModal').modal('hide');
                    location.reload();
                } else {
                    alert(res.message || 'Failed to add section.');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });

    // Load Add Link Modal
    $(document).on('click', '.addLinkBtn', function () {
        const sectionId = $(this).data('section-id');
        console.log("Add Link button clicked for section:", sectionId);

        $.ajax({
            url: '../../views/adminModals/addTransparencyModal.html',
            type: 'GET',
            success: function (data) {
                $('#addTransparencyLinkModal').remove();
                $('body').append(data);
                $('#addTransparencyLinkModal').modal('show');
                $('#sectionId').val(sectionId); // Pass section ID
            },
            error: function (xhr, status, error) {
                console.error("Error loading link modal:", error);
            }
        });
    });




    

    // Handle Add Link Form Submission
    $(document).on('submit', '#addLinkForm', function (e) {
        e.preventDefault();

        const sectionId = $('#sectionId').val().trim();
        const documentTitle = $('#documentTitle').val().trim();
        const documentLink = $('#documentLink').val().trim();

        if (!sectionId || !documentTitle || !documentLink) {
            alert('All fields are required.');
            return;
        }

        $.ajax({
            url: '../../views/adminModals/addTransparency.php',
            type: 'POST',
            data: {
                action: 'add_link',
                section_id: sectionId,
                document_title: documentTitle,
                document_link: documentLink
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    alert('Link added!');
                    $('#addTransparencyLinkModal').modal('hide');
                    location.reload();
                } else {
                    alert(res.message || 'Failed to add link.');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error (add link):", error);
            }
        });
    });
});




// VIEW SECTION MODAL
$(document).on('click', '.view-btn', function () {
    const sectionId = $(this).data('id');

    $.ajax({
        url: '../../views/adminModals/viewTransparencyModal.html',
        type: 'GET',
        success: function (modalHtml) {
            $('#viewTransparencyModal').remove();
            $('body').append(modalHtml);

            $.ajax({
                url: '../../views/adminModals/viewTransparency.php',
                type: 'POST',
                data: { section_id: sectionId },
                success: function (res) {
                    try {
                        const data = JSON.parse(res);

                        if (data.success) {
                            $('#viewTransparencyModal').data('sectionId', sectionId);

                            $('#view_section_title').text(data.section.section_title);

                            let linksHtml = '';
                            data.section.links.forEach(link => {
                                linksHtml += `
                                    <li class="list-group-item" data-id="${link.id}">
                                        <div class="d-flex justify-content-between">
                                            <span class="document-title" contenteditable="false">${link.document_title}</span>
                                            <a href="${link.document_link}" target="_blank" class="document-link" contenteditable="false">${link.document_link}</a>
                                        </div>
                                    </li>
                                `;
                            });
                            $('#view_links_container').html(linksHtml);

                            $('#view_created_by').text(data.section.created_by_name);
                            $('#view_updated_by').text(data.section.updated_by_name);
                            $('#view_updated_at').text(data.section.updated_at);

                            $('#viewTransparencyModal').modal('show');
                        } else {
                            alert(data.message || 'Failed to load section');
                        }
                    } catch (e) {
                        console.error("JSON parse error:", e, res);
                        alert('Invalid server response. See console for details.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching section data:", error);
                }
            });
        }
    });
});

// Edit or Save
$(document).on('click', '#editBtn', function () {
    const sectionTitle = $('#view_section_title');
    const documents = $('#view_links_container .list-group-item');
    const sectionId = $('#viewTransparencyModal').data('sectionId');

    if (!sectionId) {
        alert("Section ID is missing!");
        return;
    }

    if (sectionTitle.attr('contenteditable') === 'false') {
        sectionTitle.attr('contenteditable', 'true').focus();
        documents.each(function () {
            $(this).find('.document-title').attr('contenteditable', 'true');
            $(this).find('.document-link').attr('contenteditable', 'true');
        });
        $('#editBtn').text('Save');
    } else {
        const updatedSectionTitle = sectionTitle.text();
        const updatedDocuments = [];

        documents.each(function () {
            const documentId = $(this).data('id');
            const documentTitle = $(this).find('.document-title').text();
            const documentLink = $(this).find('.document-link').text();

            updatedDocuments.push({ id: documentId, title: documentTitle, link: documentLink });
        });

        $.ajax({
            url: '../../views/adminModals/updateTransparency.php',
            type: 'POST',
            data: {
                section_id: sectionId,
                section_title: updatedSectionTitle,
                documents: JSON.stringify(updatedDocuments)
            },
            success: function (res) {
                console.log("Raw response:", res);
                try {
                    const data = JSON.parse(res);
                    if (data.success) {
                        alert('Changes saved successfully!');
                        $('#viewTransparencyModal').modal('hide');
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to save changes');
                    }
                } catch (e) {
                    console.error("JSON parse error:", e, res);
                    alert('Server returned invalid data. See console.');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error saving changes:", error);
            }
        });

        $('#editBtn').text('Save');
    }
});

$('#saveSectionBtn').on('click', function () {
    const sectionId = $('#editSectionModal input[name="section_id"]').val();
    const title = $('#editSectionModal input[name="section_title"]').val();
    const userId = $('#editSectionModal input[name="user_id"]').val();

    const linkIds = [];
    const linkTitles = [];

    $('#editSectionModal .link-row').each(function () {
        linkIds.push($(this).find('input[name="link_id[]"]').val());
        linkTitles.push($(this).find('input[name="link_title[]"]').val());
    });

    $.ajax({
        url: '../../views/adminModals/updateTransparency.php',
        type: 'POST',
        data: {
            section_id: sectionId,
            title: title,
            user_id: userId,
            link_ids: linkIds,
            link_titles: linkTitles
        },
        success: function (res) {
            console.log("Raw response:", res);
            try {
                const data = JSON.parse(res);
                if (data.success) {
                    alert('Update successful');
                    $('#editSectionModal').modal('hide');
                    location.reload();
                } else {
                    alert(data.message || 'Update failed');
                }
            } catch (e) {
                console.error("JSON parse error:", e, res);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});











