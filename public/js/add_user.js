document.addEventListener("DOMContentLoaded", function () {
    
    // const userItems = document.querySelectorAll("#user-selected");
    // userItems.forEach((item) => {
    //     item.addEventListener("click", function () {
    //         const userId = this.getAttribute("data-user-id");
    //         const hiddenInputUser = this.closest(
    //             "[data-hs-combo-box]"
    //         ).querySelector('input[name="user[]"]');
    //         hiddenInputUser.value = userId;
    //     });
    // });

    const sortableList = document.getElementById("sortable-list");
    Sortable.create(sortableList, {
        handle: ".grab-handle",
        animation: 150,
    });

    const token = "119961|e1jvJWYHODtLf4u15duHkFeb4qpPmuz97f2DhfiV";
    const searchInputs = document.querySelectorAll('input[name^="user_name"]');
    console.log(searchInputs);

    searchInputs.forEach((searchInput) => {
        const resultsContainer = searchInput
            .closest("li") // Temukan elemen induk terdekat (li)
            .querySelector("#results-container"); // Dapatkan container hasil di dalam elemen tersebut

        searchInput.addEventListener("input", function () {
            const query = searchInput.value;

            // Lakukan pencarian jika terdapat lebih dari 2 karakter
            if (query.length > 2) {
                fetch(
                    `https://api-gerbang.itk.ac.id/api/siakad/pegawai/search?keyword=${encodeURIComponent(
                        query
                    )}`,
                    {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            Authorization: "Bearer " + token,
                        },
                    }
                )
                    .then((response) => response.json())
                    .then((data) => {
                        // Hapus hasil pencarian sebelumnya
                        resultsContainer.innerHTML = "";
                        if (data.data.length > 0) {
                            // Tampilkan hasil pencarian baru
                            data.data.forEach((user) => {
                                const resultWrapper =
                                    document.createElement("div");
                                resultWrapper.classList.add(
                                    "w-full",
                                    "cursor-pointer",
                                    "rounded-lg",
                                    "px-4",
                                    "py-2",
                                    "text-sm",
                                    "text-gray-800",
                                    "hover:bg-gray-100",
                                    "focus:bg-gray-100",
                                    "focus:outline-none",
                                    "dark:bg-neutral-900",
                                    "dark:text-neutral-200",
                                    "dark:hover:bg-neutral-800",
                                    "dark:focus:bg-neutral-800"
                                );

                                resultWrapper.innerHTML = `
                                <div class="flex w-full items-center justify-between">
                                    <span>${user.PE_Nama}</span>
                                </div>
                            `;

                                // Tambahkan event listener untuk memilih user
                                resultWrapper.addEventListener(
                                    "click",
                                    function () {
                                        searchInput.value = user.PE_Nama;
                                        searchInput
                                            .closest("li")
                                            .querySelector(
                                                'input[name^="user_email"]'
                                            ).value = user.PE_Email;
                                        resultsContainer.innerHTML = ""; // Hapus hasil setelah memilih user
                                        resultsContainer.style.display = "none";
                                    }
                                );

                                resultsContainer.appendChild(resultWrapper);
                            });
                            resultsContainer.style.display = "block";
                        } else {
                            // Jika tidak ada hasil, tampilkan pesan
                            resultsContainer.innerHTML =
                                '<div class="px-4 py-2 text-sm text-gray-500">No users found</div>';
                            resultsContainer.style.display = "block";
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching users:", error);
                    });
            } else {
                resultsContainer.innerHTML = "";
                resultsContainer.style.display = "none";
            }
        });
    });

});
