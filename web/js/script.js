//   document.addEventListener("DOMContentLoaded", () => {
//     document.body.addEventListener("click", function (e) {
//       if (e.target && e.target.classList.contains("fa-plus")) {
//         alert("hello");
//         const currentGroup = e.target.closest(".input-group");
//         if (!currentGroup) return;

//         const clone = currentGroup.cloneNode(true);

//         // Clear input values in the clone
//         clone.querySelectorAll("input").forEach((input) => input.value = "");

//         // Detect all inputs in current group
//         const keyInput = currentGroup.querySelector('input[name*="[key]"]');
//         const valueInput = currentGroup.querySelector('input[name*="[val]"]');

//         if (!keyInput || !valueInput) return;

//         // Extract base name dynamically from the name structure
//         const baseMatch = keyInput.name.match(/^([^\[]+\[[^\]]+\])/); // e.g., login_headers[0]
//         console.log("sameGroupInputs:", baseMatch);
//         if (!baseMatch) return;

//         const fieldBase = baseMatch[1].split('[')[0]; // e.g., login_headers
//         const groupName = fieldBase + "[" + keyInput.name.split('[')[1].split(']')[0] + "]"; // login_headers[0]

//         // Find the root name for dynamic field set like login_headers
//         const container = currentGroup.parentElement.parentElement;

//         // Count how many groups already exist for the same base
//         const allInputs = container.querySelectorAll(`input[name*="[key]"]`);
//         const sameGroupInputs = Array.from(allInputs).filter(input =>
//           input.name.includes(fieldBase + "[")
//         );

//         const newIndex = sameGroupInputs.length;
        
//         // Replace only the index in the cloned input names and ids
//         clone.querySelectorAll("input").forEach((input) => {
//           if (input.name.includes("[key]")) {
//             input.name = `${fieldBase}[${newIndex}][key]`;
//             input.id = `${fieldBase}-${newIndex}-key`;
//           }
//           if (input.name.includes("[val]")) {
//             input.name = `${fieldBase}[${newIndex}][val]`;
//             input.id = `${fieldBase}-${newIndex}-val`;
//           }
//         });

        
//         // Append clone to grandparent container
//         container.appendChild(clone);
//       }
//     });
//   });

  document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", function (e) {
      // ADD NEW ROW
      if (e.target && e.target.classList.contains("fa-plus")) {
        const currentGroup = e.target.closest(".input-group");
        if (!currentGroup) return;

        const clone = currentGroup.cloneNode(true);

        // Clear input values
        clone.querySelectorAll("input").forEach((input) => {
          input.value = "";
        });

        // Get dynamic base name
        const keyInput = currentGroup.querySelector('input[name*="[key]"]') ||
                         currentGroup.querySelector('input[name*="[value]"]');
        if (!keyInput) return;

        const nameMatch = keyInput.name.match(/^([^\[]+\[[^\]]+\])\[\d+\]\[(key|value)\]$/);
        if (!nameMatch) return;

        const baseName = nameMatch[1]; // e.g., Products[login_headers]
        const container = currentGroup.parentElement.parentElement;

        const keyInputs = container.querySelectorAll(`input[name^="${baseName}"][name*="[key]"]`);
        const newIndex = keyInputs.length;

        // Update names and IDs
        clone.querySelectorAll("input").forEach((input) => {
          console.log(input.name);
          if (input.name.includes("[key]")) {
            input.name = `${baseName}[${newIndex}][key]`;
            input.id = `${baseName.replace(/\[|\]/g, "-")}-${newIndex}-key`;
          } else if (input.name.includes("[val]")) {
            input.name = `${baseName}[${newIndex}][val]`;
            input.id = `${baseName.replace(/\[|\]/g, "-")}-${newIndex}-val`;
          } else if (input.name.includes("[value]")) {
            input.name = `${baseName}[${newIndex}][value]`;
            input.id = `${baseName.replace(/\[|\]/g, "-")}-${newIndex}-value`;
          }
        });

        // Replace the plus button with a minus
        const newIcon = clone.querySelector(".fa-plus");
        if (newIcon) {
          newIcon.classList.remove( "fa-plus", "btn-success");
          newIcon.classList.add("fa-trash", "btn-danger");
        }

        // Append to grandparent
        container.appendChild(clone);
      }

      // REMOVE ROW
      if (e.target && e.target.classList.contains("fa-trash")) {
        const groupToRemove = e.target.closest(".input-group");
        if (groupToRemove) {
          const container = groupToRemove.parentElement;
          // Prevent removing the last remaining input group
          const totalGroups = container.querySelectorAll(".input-group");
          if (totalGroups.length > 1) {
            groupToRemove.remove();
          }
        }
      }
    });
  });


