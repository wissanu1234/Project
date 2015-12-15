--------------------------------------------------------
--  Ref Constraints for Table CURRENT_TOUR
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."CURRENT_TOUR" ADD CONSTRAINT "CURRENT_TOUR_FK4" FOREIGN KEY ("PACKAGE_NO")
	  REFERENCES "SYSTEM"."PACKAGE" ("PACKAGE_NO") ENABLE;
